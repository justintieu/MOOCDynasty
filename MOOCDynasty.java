/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package moocs;

import java.io.IOException;
import java.sql.SQLException;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

/**
 *
 * @author gx
 */
public class MOOCDynasty {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws IOException, InstantiationException, ClassNotFoundException, IllegalAccessException, SQLException{

        MOOCSchool test = new Edx("EDX", "www.edx.com", false);
        test.addSchool("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=0");
        test.addSchool("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=1");
        test.addSchool("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=2");
        test.addSchool("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=3");
	test.addSchool("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=4");
	test.addSchool("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=5");
        test.addSchool("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=6");
	test.addSchool("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=7");
        test.addSchool("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=8");
        test.addSchool("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=9");
	test.addSchool("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=10");
        
        test.run();
        
        test.printResults();
    }
}
