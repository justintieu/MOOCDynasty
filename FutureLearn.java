/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package moocs;

import java.io.IOException;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

/**
 *
 * @author gx
 */
public class FutureLearn extends MOOCSchool{
    
    private String moocschool = "https://www.futurelearn.com/courses"; 
    public FutureLearn(String name, String url, boolean useDatabase) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException {
        super(name, url, useDatabase);
    }

    @Override
    public void parsePages(ArrayList<String> pages) throws IOException {
        for(String page: pages){
            Document doc = Jsoup.connect(page).get();
            Elements eles = doc.select("li[class^=media]");

            for(Element ele: eles){
                Course course = new Course();
                
                Element crspg = ele.select("h2[class=title]").first();
                course.setCourseTitle(crspg.text());
                
                String crsurl = "https://www.futurelearn.com" + ele.select("a").first().attr("href"); //Get the Course Url from href tag
                course.setCourseURL(crsurl);
                
                //Get the Course Name from H1 Tag
                Elements links = crspg.select("a[href]");
                String CourseName = crspg.select("h2").first().text(); 
                CourseName = CourseName.replace("'", "''");
                CourseName = CourseName.replace(",", "");
                course.setCourseTitle(CourseName);
                
                //
                String SCrsDesrpTemp = crspg.select("div[class=subtitle]").get(j).text();
                SCrsDesrpTemp = SCrsDesrpTemp.replace("?", "");
                SCrsDesrpTemp = SCrsDesrpTemp.replace("'", "''");
                SCrsDesrpTemp = SCrsDesrpTemp.replace(",", "");
                course.setDescription(SCrsDesrpTemp);
                
                String CrsImg  = crspg.select("a[class=media_image] > img").get(j).attr("src");; //To get the course image 
                
                
                Document crsdoc = Jsoup.connect(crsurl).get();
                String youtube = crsdoc.select("div[class=video-step-container] > iframe").attr("src"); //Youtube link
                String CrsDes = crsdoc.select("div[class=course-description] > section[class=small]").text(); //Course Description Element
                CrsDes = CrsDes.replace("'", "''");
                CrsDes = CrsDes.replace(",", "");
                
                if(CrsDes.contains("?")){
                        CrsDes = CrsDes.replace("?", "");
                }
                
                String Date = crsdoc.select("div[class=startdate]").text();
                String StrDate = Date.substring(Date.indexOf(":")+1, Date.length()); //Start date after the :
                String datechk = StrDate.substring(0, StrDate.indexOf(" "));
                if(!datechk.matches(".*\\d.*")){
                        if(StrDate.contains("n/a")){
                                StrDate = "write you own code";
                        }
                        else{
                                StrDate = "write your own code";
                        }
                }
                else{
                        String date = StrDate.substring(0, StrDate.indexOf(" "));
                        String month = StrDate.substring(StrDate.indexOf(" ")+1, StrDate.indexOf(" ")+4);
                        String year = StrDate.substring(StrDate.length()-4,StrDate.length());
                        StrDate = "write your own code";
                }
                
                Element chk = crsdoc.select("div[class=effort last]").first();
                Element crslenschk = crsdoc.select("div[class*=duration]").first();
                String crsduration;
                
                if (crslenschk==null) {
                        crsduration = "0";
                }
                else if(StrDate.contains("n/a self-paced")){
                        crsduration = "0";
                }
                else{
                    try{
                            String crsdurationtmp = crsdoc.select("div[class*=duration]").text();
                            int start = crsdurationtmp.indexOf(":")+1;
                            int end = crsdurationtmp.indexOf((" "),crsdurationtmp.indexOf(":"));
                            crsduration = crsdurationtmp.substring(start, end);
                    }
                    catch (Exception e){
                            crsduration ="0";
                            System.out.println("Exception");
                    }
                }
            }
        }
    }
}
