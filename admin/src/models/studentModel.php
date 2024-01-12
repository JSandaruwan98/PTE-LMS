<?php

class StudentModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

//===============================================================================================================================================    

    public function insertStudent($studentid, $name, $phone, $program, $batchid, $starton)
    {
        $response = array();

        // Define regular expressions for password strength, email, and phone number validation
        $phoneRegex = "/^\d{10}$/"; // Assuming a 10-digit phone number format


        
        // Perform data validation
        if (empty($name) || empty($phone) || empty($program) || empty($batchid) || empty($starton)) {
            $response['success'] = false;
            $response['message'] = "All fields are required.";
        } elseif (!preg_match($phoneRegex, $phone)) {
            $response['success'] = false;
            $response['message'] = "Invalid phone number. Please enter a 10-digit number.";
        } else {

                $numericPart = preg_replace('/[^0-9]/', '', $studentid);
                $stu_id=(int)$numericPart;

                // Insert the employee data into the database (assuming you have an "employees" table)
                $sql = "INSERT INTO student (name, phone) 
                VALUES ('$name', '$phone')";
                $sqlnext = "INSERT INTO assignstudent (batch_id, student_id, enrollment_date) 
                VALUES ('$batchid', '$stu_id','$starton')";

                $sql1 = "INSERT INTO notification (type, message) 
                VALUES ('Enrol a Student', 'Admin Enroll a new student of $name')";

                $this->conn->query($sql1);

                if ($this->conn->query($sql) === TRUE) {
                    if($this->conn->query($sqlnext) === TRUE){
                        $response['success'] = true;
                        $response['message'] = "Student '$name' created successfully!";
                    }    
                } else {
                    $response['success'] = false;
                    $response['message'] = "Employee creation failed. Please try again.";
                }
        }

        return $response;
    }

//===============================================================================================================================================

    public function viewStudent() {
            
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT S.activation AS activation,S.student_id AS student_id, S.name AS student_name, S.phone AS phone, B.program AS program, B.name AS batch_name
                FROM student AS S, assignstudent AS SB, batch AS B 
                WHERE S.student_id = SB.student_id AND B.batch_id = SB.batch_id
                LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();
        $i=1;
        while ($row = $result->fetch_assoc()) {
            $row['serial_number'] = ($page - 1) * $itemsPerPage + $i;
            $data[] = $row;
            $i++;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total 
                            FROM student AS S, assignstudent AS SB, batch AS B 
                            WHERE S.student_id = SB.student_id AND B.batch_id = SB.batch_id";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
    }

//===============================================================================================================================================

    public function getStudentId() {
        $query = "SELECT MAX(student_id) as max_id FROM student";
        $result = $this->conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $maxID = $row["max_id"];
            $nextID = "STU" . str_pad(($maxID + 1), 4, "0", STR_PAD_LEFT);
            return $nextID;
        } else {
            return "STU0001";
        }
    }

}

?>
