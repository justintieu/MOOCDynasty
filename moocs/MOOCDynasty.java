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
    	MOOCSchool fl = new FutureLearn("FutureLarn", "www.futurelearn.com", true);
        fl.addCourses("https://www.futurelearn.com/courses");
        fl.parsePages(fl.getCoursePages());
        fl.queryCourses(fl.getCourses());
//        fl.run();

        MOOCSchool edx = new Edx("EDX", "www.edx.com", true);
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
        edx.addCourses("https://www.edx.org/course-list/allschools/allsubjects/allcourses?page=11");
        edx.parsePages(edx.getCoursePages());
        
        //Category: "Art & Culture" (15)
        edx.parseCategories("https://www.edx.org/course-list/allschools/art-culture/allcourses","Art & Culture");
        //Category: "Biology & Life Sciences" (24)
        edx.parseCategories("https://www.edx.org/course-list/allschools/biology-life-sciences/allcourses","Biology & Life Sciences");
        edx.parseCategories("https://www.edx.org/course-list/allschools/biology-life-sciences/allcourses?page=1","Biology & Life Sciences");
        //Category: "Business & Management" (19)
        edx.parseCategories("https://www.edx.org/course-list/allschools/business-management/allcourses","Business & Management");
        edx.parseCategories("https://www.edx.org/course-list/allschools/business-management/allcourses?page=1","Business & Management");
        //Category: "Chemistry" (8)
        edx.parseCategories("https://www.edx.org/course-list/allschools/chemistry/allcourses","Chemistry");
        //Category: "Communication" (7)
        edx.parseCategories("https://www.edx.org/course-list/allschools/communication/allcourses","Communication");
        //Category: "Computer Science" (33)
        edx.parseCategories("https://www.edx.org/course-list/allschools/computer-science/allcourses","Computer Science");
        edx.parseCategories("https://www.edx.org/course-list/allschools/computer-science/allcourses?page=1","Computer Science");
        edx.parseCategories("https://www.edx.org/course-list/allschools/computer-science/allcourses?page=2","Computer Science");
        //Category: "Economics & Finance" (20)
        edx.parseCategories("https://www.edx.org/course-list/allschools/economics-finance/allcourses","Economics & Finance");
        edx.parseCategories("https://www.edx.org/course-list/allschools/economics-finance/allcourses?page=1","Economics & Finance");
        //Category: "Electronics" (14)
        edx.parseCategories("https://www.edx.org/course-list/allschools/electronics/allcourses","Electronics");
        //Category: "Energy & Earth Sciences" (8)
        edx.parseCategories("https://www.edx.org/course-list/allschools/energy-earth-sciences/allcourses","Energy & Earth Sciences");
        //Category: "Engineering" (41)
        edx.parseCategories("https://www.edx.org/course-list/allschools/engineering/allcourses","Engineering");
        //Category: "Environmental Studies" (12)
        edx.parseCategories("https://www.edx.org/course-list/allschools/environmental-studies/allcourses","Environmental Studies");
        //Category: "Food & Nutrition" (4)
        edx.parseCategories("https://www.edx.org/course-list/allschools/food-nutrition/allcourses","Food & Nutrition");
        //Category: "Health & Safety" (26)
        edx.parseCategories("https://www.edx.org/course-list/allschools/health-safety/allcourses","Health & Safety");
        edx.parseCategories("https://www.edx.org/course-list/allschools/health-safety/allcourses?page=1","Health & Safety");
        //Category: "History" (29)
        edx.parseCategories("https://www.edx.org/course-list/allschools/history/allcourses","History");
        edx.parseCategories("https://www.edx.org/course-list/allschools/history/allcourses?page=1","History");
        //Category: "Humanities" (41)
        edx.parseCategories("https://www.edx.org/course-list/allschools/humanities/allcourses","Humanities");
        edx.parseCategories("https://www.edx.org/course-list/allschools/humanities/allcourses?page=1","Humanities");
        edx.parseCategories("https://www.edx.org/course-list/allschools/humanities/allcourses?page=2","Humanities");
        //Category: "Law" (10)
        edx.parseCategories("https://www.edx.org/course-list/allschools/law/allcourses","Law");
        //Category: "Literature" (15)
        edx.parseCategories("https://www.edx.org/course-list/allschools/literature/allcourses","Literature");
        //Category: "Math" (20)
        edx.parseCategories("https://www.edx.org/course-list/allschools/math/allcourses","Math");
        edx.parseCategories("https://www.edx.org/course-list/allschools/math/allcourses?page=1","Math");
        //Category: "Medicine" (18)
        edx.parseCategories("https://www.edx.org/course-list/allschools/medicine/allcourses","Medicine");
        edx.parseCategories("https://www.edx.org/course-list/allschools/medicine/allcourses?page=1","Medicine");
        //Category: "Music" (4)
        edx.parseCategories("https://www.edx.org/course-list/allschools/music/allcourses","Music");
        //Category: "Philanthropy" (1)
        edx.parseCategories("https://www.edx.org/course-list/allschools/philanthropy/allcourses","Philanthropy");
        //Category: "Philosophy & Ethics" (15)
        edx.parseCategories("https://www.edx.org/course-list/allschools/philosophy-ethics/allcourses","Philosophy & Ethics");
        //Category: "Physics" (24)
        edx.parseCategories("https://www.edx.org/course-list/allschools/physics/allcourses","Physics");
        edx.parseCategories("https://www.edx.org/course-list/allschools/physics/allcourses?page=1","Physics");
        //Category: "Science" (53)
        edx.parseCategories("https://www.edx.org/course-list/allschools/science/allcourses","Science");
        edx.parseCategories("https://www.edx.org/course-list/allschools/science/allcourses?page=1","Science");
        edx.parseCategories("https://www.edx.org/course-list/allschools/science/allcourses?page=2","Science");
        edx.parseCategories("https://www.edx.org/course-list/allschools/science/allcourses?page=3","Science");
        //Category: "Social Sciences" (44)
        edx.parseCategories("https://www.edx.org/course-list/allschools/social-sciences/allcourses","Social Sciences");
        edx.parseCategories("https://www.edx.org/course-list/allschools/social-sciences/allcourses?page=1","Social Sciences");
        edx.parseCategories("https://www.edx.org/course-list/allschools/social-sciences/allcourses?page=2","Social Sciences");
        //Category: "Statistics & Data Analysis" (22)
        edx.parseCategories("https://www.edx.org/course-list/allschools/statistics-data-analysis/allcourses","Statistics & Data Analysis");
        edx.parseCategories("https://www.edx.org/course-list/allschools/statistics-data-analysis/allcourses?page=1","Statistics & Data Analysis");
        edx.printResults();
        edx.queryCourses(edx.getCourses());
//        edx.run();
//        long endTime = System.currentTimeMillis();
//        System.out.println("That took " + (endTime - startTime)/10000 + " seconds");
    }
}
