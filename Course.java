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
    public String instructors;
    public String startDate;
    public String courseLength;
    public String description;
    public String longDescription;
    public String certificate;
    public String language;
    public String courseFee;
    public String school;
    public String imageURL;
    public String courseURL;
    public String videoURL;
    
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
    public void setLongDescription(String longDescription){
        this.longDescription=longDescription;
    }
    public void setCourseLength(String courseLength){
        this.courseLength=courseLength;
    }
    public void setCertificate(String certificate){
        this.certificate=certificate;
    }
    public void setLanguage(String language){
        this.language=language;
    }
    public void setCourseFee(String courseFee){
        this.courseFee=courseFee;
    }
    public void setVideoURL(String videoURL){
        this.videoURL=videoURL;
    }
    
    public void info(){
        System.out.println("Course Number: " + courseNumber);
        System.out.println("Course Title: " + courseTitle);
        System.out.println("Start Date: " + startDate);
        System.out.println("Course Length: " + courseLength);
        System.out.println("Instructor: " + instructors);
        System.out.println("School: " + school);
        System.out.println("Short Description: " + description);
        System.out.println("Long Description: " + longDescription);
        System.out.println("Certificate: " + certificate);
        System.out.println("Course Fee: " + courseFee);
        System.out.println("Course Langugage: " + language);
        System.out.println("Image Url: " + imageURL);
        System.out.println("Course Url: " + courseURL);
        System.out.println("Video Url: " + videoURL);
        System.out.println("\n");
    }
}
