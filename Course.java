/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package moocs;

/**
 *
 * @author gx
 */
public class Course {
    public String courseNumber;
    public String courseTitle;
    public String startDate;
    public String instructors;
    public String school;
    public String description;
    public String imageURL;
    public String courseURL;
    
    public Course(){
        
    }
    
    public void setCouseNumber(String courseNumber){
        this.courseNumber=courseNumber;
    }
    public void setCourseTitle(String courseTitle){
        this.courseTitle=courseTitle;
    }
    public void setStartDate(String startDate){
        this.startDate=startDate;
    }
    public void setInstructors(String instructors){
        this.instructors=instructors;
    }
    public void setSchool(String school){
        this.school=school;
    }
    public void setDescription(String description){
        this.description=description;
    }
    public void setImageUrl(String imageUrl){
        this.imageURL=imageUrl;
    }
    public void setCourseURL(String courseURL){
        this.courseURL=courseURL;
    }
    
    public String info(){
        String info = courseNumber + "\t " + courseTitle + "\t " +startDate+ "\t " +instructors+ "\t " +school+ "\t " +description+ "\t " +imageURL+ "\t " +courseURL;
        System.out.println(info+"\n");
        return info;
    }
}
