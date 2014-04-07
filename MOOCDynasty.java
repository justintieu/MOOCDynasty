package moocs;

import java.io.IOException;
import java.sql.SQLException;

/**
*
* @author Gerald Xie, Justin Tieu
*/

public class MOOCDynasty {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws IOException, InstantiationException, ClassNotFoundException, IllegalAccessException, SQLException{        
//    	long startTime = System.currentTimeMillis();
    	FutureLearn fl = new FutureLearn("FutureLarn", "www.futurelearn.com", true);
        fl.addCourses("https://www.futurelearn.com/courses");
        fl.parsePages(fl.getCoursePages());
        fl.queryCourses(fl.getCourses());
//        fl.run();

        Edx edx = new Edx("EDX", "www.edx.com", true);
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=0");
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=1");
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=2");
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=3");
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=4");
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=5");
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=6");
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=7");
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=8");
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=9");
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=10");
        edx.parsePages(edx.getCoursePages());
        edx.queryCourses(edx.getCourses());
//        edx.run();
//        long endTime = System.currentTimeMillis();
//        System.out.println("That took " + (endTime - startTime) + " milliseconds");
    }
}
