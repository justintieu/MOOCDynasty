/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package moocs;

import java.io.IOException;
import java.sql.SQLException;
import java.util.ArrayList;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

/**
 *
 * @author gx
 */
public class Edx extends MOOCSchool{
    private String moocschool = "https://www.edx.org/course-list/"; 

    public Edx(String name, String url, boolean useDatabase) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException {
        super(name, url, useDatabase);
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
                course.setCouseNumber(topData[0]);
                course.setCourseTitle(topData[1]);

                Element courseURLElement = data.select("a").first();
                String courseURL = courseURLElement.attr("href");
                course.setCourseURL(courseURL);

                Elements startDateElement = element.select("li.first");
                course.setStartDate(startDateElement.text().split(":")[1]);

                Element professorElement = element.select("li").get(1);
                course.setInstructors(professorElement.text().split(":")[1]);

                Element schoolElement = element.select("li").get(2);
                course.setSchool(schoolElement.text());

                Element descriptionElement = element.select("div.subtitle").first();
                course.setDescription(descriptionElement.text());

                Element imgUrlElement = element.select("img").first();
                course.setImageUrl(imgUrlElement.attr("src"));
                
                Document longDescriptionPage = Jsoup.connect(courseURL).get();
                
                String longDescription = longDescriptionPage.select("div.course-detail-about").first().text();
                course.setLongDescription(longDescription);
                
                Element videoUrlElement = longDescriptionPage.select("div.course-detail-video").first();
                Elements videoUrlElements =  videoUrlElement.select("a");
                if(videoUrlElements.size()!=0)
                    course.setVideoURL(videoUrlElement.select("a").first().attr("href"));
                
                Element lengthElement = longDescriptionPage.select("div.course-detail-length").first();
                if(lengthElement!=null)
                    course.setCourseLength(lengthElement.text().split(":")[1]);
                else
                    course.setCourseLength("Unknown");
                
                Elements certElements = longDescriptionPage.select("div.course-how-take-verified");
                if(certElements.size()!=0)
                    course.setCertificate("Yes");
                else
                    course.setCertificate("No");
                
                                
                courses.add(course);
            }
        }
    }
}
