package moocs;

/**
 *
 * @author Gerald Xie, Justin Tieu
 */

public class Course {
    private String courseNumber;
    private String courseTitle;
    private String shortDescription;
    private String longDescription;
    private String courseURL;
    private String videoURL;
    private String startDate;
    private String courseLength;
    private String imageUrl;
    private String category;
    private String siteName;
    private String courseFee;
    private String language;
    private String certificate;
    private String school;
    private String timeScrapped;
    private String instructors;
    private String instructorsImage;
    
    public Course() {
    	
    }

	public String getCourseNumber() {
		return courseNumber;
	}

	public void setCourseNumber(String courseNumber) {
		this.courseNumber = courseNumber;
	}

	public String getCourseTitle() {
		return courseTitle;
	}

	public void setCourseTitle(String courseTitle) {
		this.courseTitle = courseTitle;
	}

	public String getShortDescription() {
		return shortDescription;
	}

	public void setShortDescription(String shortDescription) {
		this.shortDescription = shortDescription;
	}

	public String getLongDescription() {
		return longDescription;
	}

	public void setLongDescription(String longDescription) {
		this.longDescription = longDescription;
	}

	public String getCourseURL() {
		return courseURL;
	}

	public void setCourseURL(String courseURL) {
		this.courseURL = courseURL;
	}

	public String getVideoURL() {
		return videoURL;
	}

	public void setVideoURL(String videoURL) {
		this.videoURL = videoURL;
	}

	public String getStartDate() {
		return startDate;
	}

	public void setStartDate(String startDate) {
		this.startDate = startDate;
	}

	public String getCourseLength() {
		return courseLength;
	}

	public void setCourseLength(String courseLength) {
		this.courseLength = courseLength;
	}

	public String getImageUrl() {
		return imageUrl;
	}

	public void setImageUrl(String imageUrl) {
		this.imageUrl = imageUrl;
	}

	public String getCategory() {
		return category;
	}

	public void setCategory(String category) {
		this.category = category;
	}

	public String getSiteName() {
		return siteName;
	}

	public void setSiteName(String siteName) {
		this.siteName = siteName;
	}

	public String getCourseFee() {
		return courseFee;
	}

	public void setCourseFee(String courseFee) {
		this.courseFee = courseFee;
	}

	public String getLanguage() {
		return language;
	}

	public void setLanguage(String language) {
		this.language = language;
	}

	public String getCertificate() {
		return certificate;
	}

	public void setCertificate(String certificate) {
		this.certificate = certificate;
	}

	public String getSchool() {
		return school;
	}

	public void setSchool(String school) {
		this.school = school;
	}

	public String getTimeScrapped() {
		return timeScrapped;
	}

	public void setTimeScrapped(String timeScrapped) {
		this.timeScrapped = timeScrapped;
	}

	public String getInstructors() {
		return instructors;
	}

	public void setInstructors(String instructors) {
		this.instructors = instructors;
	}

	public String getInstructorsImage() {
		return instructorsImage;
	}

	public void setInstructorsImage(String instructorsImage) {
		this.instructorsImage = instructorsImage;
	}
    
	public void info() {
		System.out.println("Course Number: " + courseNumber);
		System.out.println("Course Title: " + courseTitle);
		System.out.println("Short Description: " + shortDescription);
		System.out.println("Long Description: " + longDescription);
		System.out.println("Course Url: " + courseURL);
		System.out.println("Video Url: " + videoURL);
		System.out.println("Start Date: " + startDate);
		System.out.println("Course Length: " + courseLength);
		System.out.println("Image Url: " + imageUrl);
		System.out.println("Category: " + category);
		System.out.println("Site Name: " + siteName);
		System.out.println("Course Fee: " + courseFee);
		System.out.println("Course Language: " + language);
		System.out.println("Certificate: " + certificate);
		System.out.println("School: " + school);
		System.out.println("Time Scrapped: " + timeScrapped);
		System.out.println("Instructor: " + instructors);
		System.out.println("Instructor Image: " + instructorsImage);
		System.out.println("\n");
    }
}
