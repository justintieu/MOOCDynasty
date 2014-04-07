package moocs;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.select.Elements;
import org.jsoup.nodes.Element;
import java.sql.*;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Calendar;

public class FutureLearn {

	/**
	 * @param args
	 * @throws IOException 
	 * @throws ClassNotFoundException 
	 * @throws IllegalAccessException 
	 * @throws InstantiationException 
	 * @throws SQLException 
	 */
	public static void main(String[] args) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException {
		String url1 = "https://www.futurelearn.com/courses";
				 
		ArrayList<String> pgcrs = new ArrayList<String>(); 
		pgcrs.add(url1);
		 
		Class.forName("com.mysql.jdbc.Driver").newInstance();
		
		//connection to localhost
		//default mysql database in local machine is ID:root with no password
		java.sql.Connection connection = DriverManager.getConnection("jdbc:mysql://localhost/scrapedcourse","root","");
		
		for(int a=0; a<pgcrs.size();a++)
		{
			String furl = (String) pgcrs.get(a);
			//connect to url with timeout(0) to set infinite time to timeout
			Document doc = Jsoup.connect(furl).timeout(0).get();
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
				//connect to url with timeout(0) to set infinite time to timeout
				Document crsdoc = Jsoup.connect(crsurl).timeout(0).get();
				//Elements crsheadele = crsdoc.select("section[class=course-header clearfix]");
				String video = crsdoc.select("div[class=video-step-container] > iframe").attr("src"); //Youtube link
				//Elements crsbodyele = crsdoc.select("section[class=course-detail clearfix]");
				String CrsDes = crsdoc.select("div[class=course-description] > section[class=small]").text(); //Course Description Element
				if(CrsDes.contains("?"))
				{
					CrsDes = CrsDes.replace("?", "");
				}
				String university = crsdoc.select("div[class=meta] > a > img").attr("alt");
				university = university.contains("'") ? university.replace("'", "''"): university;
						
				String courseId = crsdoc.select("article").attr("id").substring(7);
				String profImg = crsdoc.select("div[class=educator] > a > img").attr("src");
				String profName = crsdoc.select("div[class=educator] > a > img").attr("alt");
				profName = profName.contains("'") ? profName.replace("'", "''"): profName;
				
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
				if(video.length() > 0)
				{
					video = "http:" + video;
				} 
				else {
					video = "n/a";
				}
				String crsduration = findDuration.get(1).text().substring(findDuration.get(1).text().indexOf(':')+2, findDuration.get(1).text().indexOf(':')+3); //Get class duration and remove "Duration : "
				
				//get time scrapped
				DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
				Calendar cal = Calendar.getInstance();
				String time_scraped = dateFormat.format(cal.getTime());
				String dataQuery = "INSERT INTO `scrapedcourse`.`course_data` (`id`, `title`, `short_desc`, `long_desc`, `course_link`, `video_link`, `start_date`, `course_length`, `course_image`, `category`, `site`, `course_fee`, `language`, `certificate`, `university`, `time_scraped`) " +
																		"VALUES(NULL,'"+CourseName+"','"+SCrsDesrpTemp+"','"+CrsDes+"','"+crsurl+"','"+video+"','"+StrDate+"','"+crsduration+"','"+CrsImg+"','','FutureLearn', '0', 'English', 'yes', '" + university + "','" + time_scraped + "')";
				
				//insert course data into course_data
				System.out.println(dataQuery);           
				statement.executeUpdate(dataQuery); 

				//get id of row inserted in course_data
				ResultSet keys = statement.getGeneratedKeys();    
				keys.next();  
				int id = keys.getInt(1);
				
				String detailsQuery = "INSERT INTO `scrapedcourse`.`coursedetails` (`id`,`profname`, `profimage`, `course_id`) VALUES('" + courseId +"','" + profName + "', '" + profImg + "','" + id + "')";
				
				//insert prof data into course details
				System.out.println(detailsQuery);   
				statement.executeUpdate(detailsQuery);
				
				statement.close(); 
			 }
		}
		connection.close();   
	}
}
