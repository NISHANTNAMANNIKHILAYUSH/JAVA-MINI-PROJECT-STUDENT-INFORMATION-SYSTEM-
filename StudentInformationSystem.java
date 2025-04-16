import java.io.*;
import java.net.*;
import java.nio.charset.StandardCharsets;
import java.util.Scanner;

public class StudentInformationSystem {
    static final String BASE_URL = "http://localhost/student_system/"; // Update to your PHP folder path

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        int choice;

        do {
            System.out.println("\n===== Student Information System =====");
            System.out.println("1. Enroll Student");
            System.out.println("2. Add Academic Record");
            System.out.println("3. Schedule Class");
            System.out.println("4. Add Announcement");
            System.out.println("5. Add Fee Record");
            System.out.println("6. View Student Information"); // New Option
            System.out.println("7. Exit");
            System.out.print("Select an option: ");
            choice = scanner.nextInt();
            scanner.nextLine(); // consume newline

            switch (choice) {
                case 1 -> enrollStudent(scanner);
                case 2 -> addAcademicRecord(scanner);
                case 3 -> scheduleClass(scanner);
                case 4 -> addAnnouncement(scanner);
                case 5 -> addFee(scanner);
                case 6 -> viewStudentInfo(scanner); // New Case
                case 7 -> System.out.println("Exiting...");
                default -> System.out.println("Invalid option!");
            }
        } while (choice != 7);

        scanner.close();
    }

    static void enrollStudent(Scanner scanner) {
        System.out.println("\n-- Enroll Student --");
        System.out.print("Student ID: ");
        String studentId = scanner.nextLine();  // Add Student ID input
        System.out.print("Name: ");
        String name = scanner.nextLine();
        System.out.print("DOB (YYYY-MM-DD): ");
        String dob = scanner.nextLine();
        System.out.print("Email: ");
        String email = scanner.nextLine();
        System.out.print("Course: ");
        String course = scanner.nextLine();
    
        String data = "student_id=" + encode(studentId) + "&name=" + encode(name) + "&dob=" + encode(dob) +
                      "&email=" + encode(email) + "&course=" + encode(course);
    
        sendPostRequest("enroll.php", data);
    }
    

    static void addAcademicRecord(Scanner scanner) {
        System.out.println("\n-- Add Academic Record --");
        System.out.print("Student ID: ");
        String id = scanner.nextLine();
        System.out.print("Subject: ");
        String subject = scanner.nextLine();
        System.out.print("Grade: ");
        String grade = scanner.nextLine();
        System.out.print("Semester: ");
        String semester = scanner.nextLine();

        String data = "student_id=" + encode(id) + "&subject=" + encode(subject) +
                      "&grade=" + encode(grade) + "&semester=" + encode(semester);

        sendPostRequest("add_grade.php", data);
    }

    static void scheduleClass(Scanner scanner) {
        System.out.println("\n-- Schedule Class --");
        System.out.print("Course: ");
        String course = scanner.nextLine();
        System.out.print("Subject: ");
        String subject = scanner.nextLine();
        System.out.print("Teacher: ");
        String teacher = scanner.nextLine();
        System.out.print("Day: ");
        String day = scanner.nextLine();
        System.out.print("Time Slot: ");
        String time = scanner.nextLine();

        String data = "course=" + encode(course) + "&subject=" + encode(subject) +
                      "&teacher=" + encode(teacher) + "&day=" + encode(day) + "&time=" + encode(time);

        sendPostRequest("add_schedule.php", data);
    }

    static void addAnnouncement(Scanner scanner) {
        System.out.println("\n-- Add Announcement --");
        System.out.print("Title: ");
        String title = scanner.nextLine();
        System.out.print("Message: ");
        String message = scanner.nextLine();

        String data = "title=" + encode(title) + "&message=" + encode(message);
        sendPostRequest("send_message.php", data);
    }

    static void addFee(Scanner scanner) {
        System.out.println("\n-- Add Fee Record --");
        System.out.print("Student ID: ");
        String studentId = scanner.nextLine();
        System.out.print("Amount: ");
        String amount = scanner.nextLine();
        System.out.print("Due Date (YYYY-MM-DD): ");
        String due = scanner.nextLine();

        String data = "student_id=" + encode(studentId) + "&amount=" + encode(amount) +
                      "&due_date=" + encode(due);

        sendPostRequest("add_fee.php", data);
    }

    static void viewStudentInfo(Scanner scanner) {
        System.out.println("\n-- View Student Information --");
        System.out.print("Enter Student ID: ");
        String studentId = scanner.nextLine();

        String data = "student_id=" + encode(studentId);
        sendPostRequest("get_student_info.php", data);
    }

    static String encode(String value) {
        return URLEncoder.encode(value, StandardCharsets.UTF_8);
    }

    static void sendPostRequest(String phpFile, String data) {
        try {
            URL url = new URL(BASE_URL + phpFile);
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();

            conn.setRequestMethod("POST");
            conn.setDoOutput(true);
            conn.setRequestProperty("Content-Type", "application/x-www-form-urlencoded");

            try (OutputStream os = conn.getOutputStream()) {
                byte[] input = data.getBytes(StandardCharsets.UTF_8);
                os.write(input, 0, input.length);
            }

            try (BufferedReader br = new BufferedReader(
                    new InputStreamReader(conn.getInputStream(), StandardCharsets.UTF_8))) {
                StringBuilder response = new StringBuilder();
                String line;

                while ((line = br.readLine()) != null) {
                    response.append(line.trim()).append("\n");
                }
                System.out.println("Server Response:\n" + response);
            }

        } catch (IOException e) {
            System.out.println("Error: " + e.getMessage());
        }
    }
}
