package moocs;

import java.sql.*;
import java.io.IOException;
import java.util.ArrayList;

/**
*
* @author Gerald Xie, Justin Tieu
*/

public class MOOCSchool {
    private String moocschool; 
    private String url;
	private Connection connection;
    private boolean useDatabase = false;
    private ArrayList<String> coursePages = new ArrayList<String>();
    private ArrayList<Course> courses = new ArrayList<Course>();
    
    public MOOCSchool(String name, String url, boolean useDatabase) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException {
        this.moocschool = name;
        this.url = url;
        this.useDatabase=useDatabase;
                
        if(useDatabase==true){
            Class.forName("com.mysql.jdbc.Driver").newInstance();
            connection = DriverManager.getConnection("jdbc:mysql://localhost/scrapedcourse","root","");
        }
    }
    
    public String getMoocschool() {
		return moocschool;
	}

	public void setMoocschool(String moocschool) {
		this.moocschool = moocschool;
	}

	public String getUrl() {
		return url;
	}

	public void setUrl(String url) {
		this.url = url;
	}

	public Connection getConnection() {
		return connection;
	}

	public void setConnection(Connection connection) {
		this.connection = connection;
	}

	public boolean isUseDatabase() {
		return useDatabase;
	}

	public void setUseDatabase(boolean useDatabase) {
		this.useDatabase = useDatabase;
	}

	public ArrayList<String> getCoursePages() {
		return coursePages;
	}

	public void setCoursePages(ArrayList<String> coursePages) {
		this.coursePages = coursePages;
	}

	public ArrayList<Course> getCourses() {
		return courses;
	}

	public void setCourses(ArrayList<Course> courses) {
		this.courses = courses;
	}
	
	public void addCourse(Course course) {
		this.courses.add(course);
	}
    
    public boolean addToDatabase(Course c) throws SQLException{
        
        Statement statement = connection.createStatement();
		
        String courseDataQuery = "INSERT INTO `scrapedcourse`.`course_data` (`id`, `title`, `short_desc`, `long_desc`, `course_link`, `video_link`, `start_date`, `course_length`, `course_image`, `category`, `site`, `course_fee`, `language`, `certificate`, `university`, `time_scraped`) VALUES(NULL,'"
					                +c.getCourseTitle()		+ "','"
					                +c.getShortDescription()+ "','"
					                +c.getLongDescription()	+ "','"
					                +c.getCourseURL()		+ "','"
					                +c.getVideoURL()		+ "','"
					                +c.getStartDate()		+ "','"
					                +c.getCourseLength()	+ "','"
					                +c.getImageUrl()		+ "','"
					                +""						+ "','" 
					                +c.getSiteName()		+ "','"
					                +c.getCourseFee()		+ "','"
					                +c.getLanguage()		+ "','"
					                +c.getCertificate()		+ "','"
					                +c.getSchool()			+ "','"
					                +c.getTimeScrapped()		+ "')";
        System.out.println(courseDataQuery);
        statement.execute(courseDataQuery);
        
        //get id of the row inserted into course data table
		ResultSet keys = statement.getGeneratedKeys();    
		keys.next();  
		int id = keys.getInt(1);
        
        String courseDetailsQuery = "INSERT INTO `scrapedcourse`.`coursedetails` (`id`,`profname`, `profimage`, `course_id`) VALUES('" 
        							+ id 						+ "','" 
    								+ c.getInstructors() 		+ "', '" 
    								+ c.getInstructorsImage() 	+ "','" 
    								+ id 
    								+ "')";
        System.out.println(courseDetailsQuery);
        statement.execute(courseDetailsQuery);
        statement.close(); 
        return true;
    }
    
    public void addCourses(String urlpage){
        coursePages.add(urlpage);
    }
    
    public void parsePages(ArrayList<String> pages) throws IOException{
    
    }
    
    public void queryCourses(ArrayList<Course> courses) {
    	for(Course course : courses) {
    		try {
				addToDatabase(course);
			} catch (SQLException e) {
				e.printStackTrace();
			}
    	}
    }
    
    public void run() throws IOException, SQLException{
        this.parsePages(coursePages);
    }
    
    public void printResults(){
        for(Course course: courses){
            course.info();
        }
    }
}
