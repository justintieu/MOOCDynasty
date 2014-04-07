package moocs;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.select.Elements;
import java.sql.*;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Calendar;

/**
*
* @author Justin Tieu
*/

public class FutureLearn extends MOOCSchool {

	public FutureLearn(String name, String url, boolean useDatabase) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException {
		super(name, url, useDatabase);
	}

	 @Override
    public void parsePages(ArrayList<String> pages) throws IOException {
		for(String page : pages) {
			//connect to url with timeout(0) to set infinite time to timeout
			Document doc = Jsoup.connect(page).timeout(0).get();
			Elements ele = doc.select("li[class^=media]");
			Elements crspg = ele.select("h2[class^=title]");
			Elements link = crspg.select("a");
			
			for (int j=0; j<link.size();j++)
			{
				Course course = new Course();
				
				String courseTitle = crspg.get(j).text();
				courseTitle = courseTitle.replace("'", "''");
				course.setCourseTitle(courseTitle);
				
				String courseUrl = "https://www.futurelearn.com" +link.get(j).attr("href"); //Get the Course Url from href tag
				course.setCourseURL(courseUrl);
				
				
				String shortDesc = doc.select("p[class=introduction").get(j).text();	//Get short course description
				shortDesc = shortDesc.replace("'", "''");
				shortDesc = shortDesc.replace(",", "");
				course.setShortDescription(shortDesc);
				
				String imageUrl = doc.select("a[class=media_image] > img").get(j).attr("src"); //To get the course image 
				course.setImageUrl(imageUrl);
				
				Document crsdoc = Jsoup.connect(courseUrl).timeout(0).get();
				String videoURL = crsdoc.select("div[class=video-step-container] > iframe").attr("src"); //Youtube link
				videoURL = videoURL.length() > 0 ? "http:" + videoURL : "n/a";
				course.setVideoURL(videoURL);
				
				String longDesc = crsdoc.select("div[class=course-description] > section[class=small]").text(); //Course Description Element
				if(longDesc.contains("?"))
				{
					longDesc = longDesc.replace("?", "");
				}
				course.setLongDescription(longDesc);
				
				String school = crsdoc.select("div[class=meta] > a > img").attr("alt");
				school = school.contains("'") ? school.replace("'", "''"): school;
				course.setSchool(school);
				
				String courseId = crsdoc.select("article").attr("id").substring(7);
				course.setCourseNumber(courseId);
				
				String instructors = crsdoc.select("div[class=educator] > a > img").attr("alt");
				instructors = instructors.contains("'") ? instructors.replace("'", "''"): instructors;
				course.setInstructors(instructors);
				
				String instructorsImage = crsdoc.select("div[class=educator] > a > img").attr("src");
				course.setInstructorsImage(instructorsImage);
				
				Elements findDuration = crsdoc.select("ul[class=list] > li > p");
				String startDate = "";
				String datechk = findDuration.get(0).text();
				if(datechk.equals("Starts late 2014"))
				{
					startDate = "2014-09-01";
				}
				else
				{
					startDate = findDuration.get(0).select("time").attr("datetime");
				}
				course.setStartDate(startDate);
				
				String courseLength = findDuration.get(1).text().substring(findDuration.get(1).text().indexOf(':')+2, findDuration.get(1).text().indexOf(':')+3); //Get class duration and remove "Duration : "
				course.setCourseLength(courseLength);
				
				course.setCategory("");
				course.setCertificate("yes");
				course.setCourseFee("0");
				course.setLanguage("English");
				course.setSiteName("FutureLearn");

                DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
        		Calendar cal = Calendar.getInstance();
        		String timeScrapped = dateFormat.format(cal.getTime());
        		course.setTimeScrapped(timeScrapped);
        		
				addCourse(course);
			 }
		}
	}
}