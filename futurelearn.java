package moocs;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.select.Elements;
import org.jsoup.nodes.Element;
import java.sql.*;
import java.io.IOException;
import java.util.ArrayList;

public class futurelearn {

	/**
	 * @param args
	 * @throws IOException 
	 * @throws ClassNotFoundException 
	 * @throws IllegalAccessException 
	 * @throws InstantiationException 
	 * @throws SQLException 
	 */
	public static void main(String[] args) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException {
		// TODO Auto-generated method stub
		String url1 = "https://www.futurelearn.com/courses";
		
		 
		ArrayList pgcrs = new ArrayList<String>(); //Array which will store each course URLs 
		pgcrs.add(url1);
		 
		Class.forName("com.mysql.jdbc.Driver").newInstance();
		java.sql.Connection connection = DriverManager.getConnection("jdbc:mysql://localhost/scrapedcourse","root","");
		//make sure you create a database named scrapedcourse in your local mysql database before running this code
		//default mysql database in your local machine is ID:root with no password
		for(int a=0; a<pgcrs.size();a++)
		{
			String furl = (String) pgcrs.get(a);
			Document doc = Jsoup.connect(furl).get();
			Elements ele = doc.select("li[class^=media]");
			Elements crspg = ele.select("h2[class^=title]");
			Elements link = crspg.select("a");
			for (int j=0; j<link.size();j++)
			{
				Statement statement = connection.createStatement();
			    
				String crsurl = "https://www.futurelearn.com" +link.get(j).attr("href"); //Get the Course Url from href tag
				//System.out.println(crsurl);
				String CourseName = crspg.get(j).text(); //Get the Course Name 
				CourseName = CourseName.replace("'", "''");
				String SCrsDesrpTemp = doc.select("p[class=introduction").get(j).text();	//Get short course description
				SCrsDesrpTemp = SCrsDesrpTemp.replace("'", "''");
				SCrsDesrpTemp = SCrsDesrpTemp.replace(",", "");
				String CrsImg  = doc.select("a[class=media_image] > img").get(j).attr("src"); //To get the course image 
				
				Document crsdoc = Jsoup.connect(crsurl).get();
				//Elements crsheadele = crsdoc.select("section[class=course-header clearfix]");
				String youtube = crsdoc.select("div[class=video-step-container] > iframe").attr("src"); //Youtube link
				//Elements crsbodyele = crsdoc.select("section[class=course-detail clearfix]");
				String CrsDes = crsdoc.select("div[class=course-description] > section[class=small]").text(); //Course Description Element
				if(CrsDes.contains("?"))
				{
					CrsDes = CrsDes.replace("?", "");
				}
				
				String courseId = crsdoc.select("article").attr("id").substring(7);
				String profImg = crsdoc.select("div[class=educator] > a > img").attr("src");
				String profName = crsdoc.select("div[class=educator] > a > img").attr("alt");
				
				Elements findDuration = crsdoc.select("ul[class=list] > li > p");
				
				String StrDate = "";
				String datechk = findDuration.get(0).text();
				if(datechk.equals("Starts late 2014"))
				{
					StrDate = "2014-09-01";
				}
				else
				{
					StrDate = findDuration.get(0).select("time").attr("datetime");
				}
				if(youtube.length() > 0)
				{
					youtube = "http:" + youtube;
				} 
				else {
					youtube = "n/a";
				}
				String crsduration = findDuration.get(1).text().substring(findDuration.get(1).text().indexOf(':')+2, findDuration.get(1).text().indexOf(':')+3); //Get class duration and remove "Duration : "
				String dataQuery = "INSERT INTO `scrapedcourse`.`course_data` (`id`, `title`, `short_desc`, `long_desc`, `course_link`, `video_link`, `start_date`, `course_length`, `course_image`, `category`, `site`) VALUES(NULL,'"+CourseName+"','"+SCrsDesrpTemp+"','"+CrsDes+"','"+crsurl+"','"+youtube+"','"+StrDate+"','"+crsduration+"','"+CrsImg+"','','FutureLearn')";
				String detailsQuery = "INSERT INTO `scrapedcourse`.`coursedetails` (`id`,`profname`, `profimage`, `course_id`) VALUES(3,'" + profName + "', '" + profImg + "', '" + courseId + "')";
//				System.out.println(dataQuery);       
//				System.out.println(detailsQuery);       
//				statement.executeUpdate(dataQuery); 
//				statement.executeUpdate(detailsQuery);
				String query = "INSERT INTO `scrapedcourse`.`data` (`id`, `title`, `short_desc`, `long_desc`, `course_link`, `video_link`, `start_date`, `course_length`, `course_image`, `category`, `site`, `profname`, `profimage`, `course_id`) VALUES (NULL,'"+CourseName+"','"+SCrsDesrpTemp+"','"+CrsDes+"','"+crsurl+"','"+youtube+"','"+StrDate+"','"+crsduration+"','"+CrsImg+"','','FutureLearn','" + profName + "', '" + profImg + "', '" + courseId + "')";
				System.out.println(query);
				statement.executeUpdate(query);
				statement.close(); 
			 }
		}
		connection.close();   
	}
}