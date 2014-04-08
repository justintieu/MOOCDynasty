package moocs;

import java.io.IOException;
import java.sql.SQLException;
import java.text.DateFormat;
import java.text.DecimalFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

/**
*
* @author Gerald Xie, Justin Tieu
*/

public class Edx extends MOOCSchool{
    private String moocschool = "https://www.edx.org/course-list/"; 

    public Edx(String name, String url, boolean useDatabase) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException {
        super(name, url, useDatabase);
    }
    
    public String getMonth(String inputMonth) {
	    	if(inputMonth.contains("Jan"))	return "01";
	    	else if(inputMonth.contains("Feb"))	return "02";
	    	else if(inputMonth.contains("Mar"))	return "03";
	    	else if(inputMonth.contains("Apr"))	return "04";
	    	else if(inputMonth.contains("May"))	return "05";
	    	else if(inputMonth.contains("Jun"))	return "06";
	    	else if(inputMonth.contains("Jul"))	return "07";
	    	else if(inputMonth.contains("Aug"))	return "08";
	    	else if(inputMonth.contains("Sep"))	return "09";
	    	else if(inputMonth.contains("Oct"))	return "10";
	    	else if(inputMonth.contains("Nov"))	return "11";
	    	else if(inputMonth.contains("Dec"))	return "12";
	    	else return "00";
    }
    	
    @Override
    public void parsePages(ArrayList<String> pages) throws IOException {
        for(String page: pages){
            Document web = Jsoup.connect(page).get();
            Elements elements = web.select("div.views-row");
            //System.out.println(elements);
            for(Element element: elements){
                Course course = new Course();

                Elements data = element.select("h2.title");

                String numtitle = data.text();
                String[] topData = numtitle.split(":");
                course.setCourseNumber(topData[0]);
                String courseTitle = topData[1];
				courseTitle = courseTitle.contains("'") ? courseTitle.replace("'", "''") : courseTitle;
				courseTitle = courseTitle.contains("?") ? courseTitle.replace("?", "") : courseTitle;
                course.setCourseTitle(courseTitle);

                Element courseUrlElement = data.select("a").first();
                String courseURL = courseUrlElement.attr("href");
                course.setCourseURL(courseURL);

                Elements startDateElement = element.select("li.first");
                String startDate;
                if(startDateElement.text().split(":")[1].contains("self-paced")) {
            		startDate = "0000-00-00";
                } else if(startDateElement.text().split(":")[1].contains("Quarter")) {
	                String[] date = startDateElement.text().split(":")[1].split(" ");
                	if(date[0].equals("1st")) {
                		startDate = "2014-01-01";
                	} else if(date[0].equals("2nd")) {
                		startDate = "2014-04-01";
                	} else if(date[0].equals("3rd")) {
                		startDate = "2014-07-01";
                	} else {
                		startDate = "2014-10-01";
                	}
                } else {
	                String[] date = startDateElement.text().split(":")[1].split(" ");
	                if(date[1].length() > 2) {
		                String month = this.getMonth(date[1]);
		                String year = date[2];
		                startDate = year + "-" + month + "-01";
	                } else {
		                String day = date[1].length() < 2 ? "0"+date[1] : date[1]; 
		                String month = this.getMonth(date[2]);
		                String year = date[3];
		                startDate = year + "-" + month + "-" + day;
	                }
                }
            	course.setStartDate(startDate);

                Element schoolElement = element.select("li").get(2);
                String school = schoolElement.text();
                course.setSchool(school.substring(0, school.length()-1));

                Element descriptionElement = element.select("div.subtitle").first();
                String shortDesc = descriptionElement.text();
                shortDesc = shortDesc.contains("'") ? shortDesc.replace("'", "''") : shortDesc;
                shortDesc = shortDesc.contains("?") ? shortDesc.replace("?", "") : shortDesc;
                course.setShortDescription(shortDesc);

                Element imgUrlElement = element.select("img").first();
                course.setImageUrl(imgUrlElement.attr("src"));

                Document coursePage = Jsoup.connect(courseURL).timeout(0).get();
                
                Elements longDescElement = coursePage.select("div[class=course-section course-detail-about] > div");
                String longDesc = longDescElement.text();
                longDesc = longDesc.contains("'") ? longDesc.replace("'", "''") : longDesc;
                longDesc = longDesc.contains("?") ? longDesc.replace("?", "") : longDesc;
                course.setLongDescription(longDesc);
                
                if(coursePage.select("div[class=course-detail-video]").text().length() == 0) {
                	course.setVideoURL("n/a");
                } else {
	                Element videoElement = coursePage.select("div[class=course-detail-video] > a").first();
	                String videoURL = videoElement.attr("href");
	                course.setVideoURL(videoURL);
                }
                
                Elements courseLengthElement = coursePage.select("div[class=course-detail-length item]");
                String[] courseLength = courseLengthElement.text().split(" ");
                if(courseLength.length == 4) {
                    course.setCourseLength(courseLength[2]);
            	} else if(startDateElement.text().split(":")[1].contains("self-paced")) {
                	course.setCourseLength("0");
                } else if(coursePage.select("div[class=course-detail-effort item]").text().contains(" weeks)")) {
                	courseLengthElement = coursePage.select("div[class=course-detail-effort item]");
                    courseLength = courseLengthElement.text().split(" ");
                	String length = courseLength[4];
                	length = length.contains("(") ? length.replace("(", "") : length;
                    course.setCourseLength(length);
                } else {
                	course.setCourseLength("0");
                }
                
                Element professorElement = coursePage.select("ul[class=staff-list] > li").first();
                String instructors = professorElement.select("h4[class=staff-title]").text();
				instructors = instructors.contains("'") ? instructors.replace("'", "''"): instructors;
                course.setInstructors(instructors);
                course.setInstructorsImage(professorElement.select("div[class=staff-image] > img").attr("src"));
                
                course.setCategory("");
				course.setCertificate("yes");
				course.setCourseFee("0");
				course.setLanguage("English");
				course.setSiteName("EDX");
                
                //get time scrapped
                DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
        		Calendar cal = Calendar.getInstance();
        		String timeScrapped = dateFormat.format(cal.getTime());
        		course.setTimeScrapped(timeScrapped);
        		
        		course.info();
        		addCourse(course);
            }
        }
    }
}
