package moocs;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.select.Elements;
import org.jsoup.nodes.Element;
import java.sql.*;
import java.io.IOException;
import java.util.ArrayList;

public class edx {

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
		String url1 = "https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=0";
		String url2 = "https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=1";
		String url3 = "https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=2";
		String url4 = "https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=3";
		String url5 = "https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=4";
		String url6 = "https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=5";
		String url7 = "https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=6";
		String url8 = "https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=7";
		String url9 = "https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=8";
		String url10 = "https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=9";
		String url11 = "https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=10";
		
		 
		ArrayList pgcrs = new ArrayList<String>(); //Array which will store each course URLs 
		pgcrs.add(url1);
		pgcrs.add(url2);
		pgcrs.add(url3);
		pgcrs.add(url4);
		pgcrs.add(url5);
		pgcrs.add(url6);
		pgcrs.add(url7);
		pgcrs.add(url8);
		pgcrs.add(url9);
		pgcrs.add(url10);
		pgcrs.add(url11);
		 
		Class.forName("com.mysql.jdbc.Driver").newInstance();
		java.sql.Connection connection = DriverManager.getConnection("jdbc:mysql://localhost/scrapedcourse","root","");
		//make sure you create a database named scrapedcourse in your local mysql database before running this code
		//default mysql database in your local machine is ID:root with no password
		for(int a=0; a<pgcrs.size();a++)
		{
			String furl = (String) pgcrs.get(a);
			Document doc = Jsoup.connect(furl).get();
			Elements ele = doc.select("div[class*=views-row]");
			Elements crspg = ele.select("div[class*=course-tile]");
			Elements link = crspg.select("div[href]");
			
			for (int j=0; j<link.size();j++)
			{
				//Statement statement = connection.createStatement();
			    
				String crsurl = "https://www.edx.org" +link.get(j).attr("href"); //Get the Course Url from href tag
				System.out.println(crsurl);
				String CourseName = crspg.select("h1").get(j).text(); //Get the Course Name from H1 Tag
				CourseName = CourseName.replace("'", "''");
				CourseName = CourseName.replace(",", "");
				String SCrsDesrpTemp = crspg.select("div[class=subtitle]").get(j).text();
				SCrsDesrpTemp = SCrsDesrpTemp.replace("?", "");
				//String SCrsDesrp = SCrsDesrpTemp.substring(0, (SCrsDesrpTemp.length()-5)); //To get the course description and remove the extra characters at the end.
				SCrsDesrpTemp = SCrsDesrpTemp.replace("'", "''");
				SCrsDesrpTemp = SCrsDesrpTemp.replace(",", "");
				String CrsImg = crspg.select("img[class=image-style-none]").get(j).attr("src"); //To get the course image 
				Document crsdoc = Jsoup.connect(crsurl).get();
				//Elements crsheadele = crsdoc.select("section[class=course-header clearfix]");
				String youtube = crsdoc.select("div[class=course-detail-video] > a").attr("href"); //Youtube link
				//Elements crsbodyele = crsdoc.select("section[class=course-detail clearfix]");
				String CrsDes = crsdoc.select("div[class*=course-detail-about]").text(); //Course Description Element
				CrsDes = CrsDes.replace("'", "''");
				CrsDes = CrsDes.replace(",", "");
				if(CrsDes.contains("?"))
				{
					CrsDes = CrsDes.replace("?", "");
				}
				String Date = crsdoc.select("div[class=startdate]").text();
				String StrDate = Date.substring(Date.indexOf(":")+1, Date.length()); //Start date after the :
				String datechk = StrDate.substring(0, StrDate.indexOf(" "));
				if(!datechk.matches(".*\\d.*"))
				{
					if(StrDate.contains("n/a"))
					{
						StrDate = "write you own code";
					}
					else
					{
						StrDate = "write your own code";
					}
				}
				else
				{
					String date = StrDate.substring(0, StrDate.indexOf(" "));
					String month = StrDate.substring(StrDate.indexOf(" ")+1, StrDate.indexOf(" ")+4);
					String year = StrDate.substring(StrDate.length()-4,StrDate.length());
					StrDate = "write your own code";
				}
				Element chk = crsdoc.select("div[class=effort last]").first();
				Element crslenschk = crsdoc.select("div[class*=duration]").first();
				String crsduration;
				if (crslenschk==null)
				{
					crsduration = "0";
				}
				else if(StrDate.contains("n/a self-paced"))
				{
					crsduration = "0";
				}
				else
				{
					try{
						String crsdurationtmp = crsdoc.select("div[class*=duration]").text();
						int start = crsdurationtmp.indexOf(":")+1;
						int end = crsdurationtmp.indexOf((" "),crsdurationtmp.indexOf(":"));
						crsduration = crsdurationtmp.substring(start, end);
					}
					catch (Exception e)
					{
						crsduration ="0";
						System.out.println("Exception");
					}
				}
				String query = "insert into course_data values(null,'"+CourseName+"','"+SCrsDesrpTemp+"','"+CrsDes+"','"+crsurl+"','"+youtube+"',"+StrDate+","+crsduration+",'"+CrsImg+"','','Edx')";
				System.out.println(query);                	
				statement.executeUpdate(query);
				statement.close(); 
			 }
		}
		connection.close();   
	}
}