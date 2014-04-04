/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package moocs;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.select.Elements;
import org.jsoup.nodes.Element;
import java.sql.*;
import java.io.IOException;
import java.util.ArrayList;
import java.util.concurrent.ExecutionException;

/**
 *
 * @author gx
 */
public class MOOCSchool {
    private String moocschool; 
    private String url;
    private Connection connection;
    private boolean useDatabase = false;
    
    public ArrayList<String> schoolPages = new ArrayList<String>();
    public ArrayList<Course> courses = new ArrayList<Course>();
    
    public MOOCSchool(String name, String url, boolean useDatabase) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException {
        this.moocschool = name;
        this.url = url;
        this.useDatabase=useDatabase;
                
        if(useDatabase==true){
            Class.forName("com.mysql.jdbc.Driver").newInstance();
            connection = DriverManager.getConnection("jdbc:mysql://localhost/scrapedcourse","root","");
        }
    }
    
    public boolean addToDatabase(String courseName, String SCrsDesrpTemp, 
            String CrsDes,String crsurl,String youtube,String StrDate,
            String crsduration,String CrsImg, String name) throws SQLException{
        
        Statement statement = connection.createStatement();
        
        String query = "insert into course_data values(null,'"
                +courseName+"','"
                +SCrsDesrpTemp+"','"
                +CrsDes+"','"
                +crsurl+"','"
                +youtube+"',"
                +StrDate+","
                +crsduration+",'"
                +CrsImg
                +"','',"
                +name
                +");";
        
        statement.execute(query);
        statement.close(); 
        return true;
    }
    
    public void addSchool(String urlpage){
        schoolPages.add(urlpage);
    }
    
    public void parsePages(ArrayList<String> pages) throws IOException{
        
    }
    
    public void run()throws IOException, SQLException{
        this.parsePages(schoolPages);
    }
    
    public void printResults(){
        for(Course course: courses){
            course.info();
        }
    }
}
