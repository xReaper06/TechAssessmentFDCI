<?php

include "../config/index.php";
class Controller
{
    public function login($email, $pass)
    {
        global $conn;
        try {
            $tmp = md5($pass);
            $query = $conn->prepare("SELECT name,email FROM users_tbl WHERE email=? AND password = ?;");
            $query->bind_param('ss', $email, $tmp);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows === 0) {
                $query->close();
                $conn->close();
                return json_encode([
                    'status' => 'Error',
                    'message' => 'User does not exist',
                ]);
            } else {
                $row = $result->fetch_assoc();
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                $query->close();
                $conn->close();
                return json_encode([
                    'status' => 'Success',
                    'message' => 'Successfully logged in'
                ]);
            }
        } catch (Exception $th) {
            $conn->close();
            return json_encode([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }
    public function registration($name, $email, $pass)
    {
        global $conn;
        try {
            $query = $conn->prepare("SELECT email FROM users_tbl WHERE email=?;");
            $query->bind_param('s', $email);
            $query->execute();
            $result = $query->get_result();
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            if (count($data) > 0) {
                $query->close();
                $conn->close();
                return json_encode([
                    'status' => 'Error',
                    'message' => 'Email is already Exists'
                ]);
            } else {
                $query->close();
                $tmp = md5($pass);
                $newQuery = $conn->prepare("INSERT INTO users_tbl(name,email,password,created_at)VALUES(?,?,?,now())");
                $newQuery->bind_param('sss', $name, $email, $tmp);
                $newResult = $newQuery->execute();
                if ($newResult) {
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $newQuery->close();
                    $conn->close();
                    return json_encode([
                        'status' => 'Success',
                        'message' => 'Email is already Exists'
                    ]);
                }
            }
        } catch (Exception $th) {
            $conn->close();
            return json_encode([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }
    public function Delete($id)
    {
        global $conn;
        try {
            if ($this->checkifUserExist($_SESSION['name'], $_SESSION['email'])) {
                $query = $conn->prepare("DELETE contacts_tbls WHERE id = ?");
                $query->bind_param('i', $id);
                $result = $query->execute();
                if ($result) {
                    return json_encode([
                        'status' => 'Success',
                        'message' => 'SuccessFully Deleted'
                    ]);
                }
            } else {
                return json_encode([
                    'status' => 'Error',
                    'message' => 'Login First'
                ]);
            }
        } catch (Exception $th) {
            $conn->close();
            return json_encode([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }
    public function Edit($id, $name, $company, $phone, $email)
    {
        global $conn;
        try {
            if ($this->checkifUserExist($_SESSION['name'], $_SESSION['email'])) {
                $query = $conn->prepare("UPDATE contacts_tbl SET name = ?,company = ?,phone=?,email=? WHERE id = ?");
                $query->bind_param('ssssi', $name, $company, $phone, $email, $id);
                $result = $query->execute();
                if ($result) {
                    return json_encode([
                        'status' => 'Success',
                        'message' => 'SuccessFully Updated'
                    ]);
                }
            } else {
                return json_encode([
                    'status' => 'Error',
                    'message' => 'Login First'
                ]);
            }
        } catch (Exception $th) {
            $conn->close();
            return json_encode([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }
    public function Add($name, $company, $phone, $email)
    {
        global $conn;
        try {
            if ($this->checkifUserExist($_SESSION['name'], $_SESSION['email'])) {
                $query = $conn->prepare("INSERT INTO contacts_tbl(user_id,name,company,phone,email,created_at) VALUES (?,?,?,?,?,now())");
                $query->bind_param('issss', $this->getId(), $name, $company, $phone, $email);
                $result = $query->execute();
                if ($result) {
                    return json_encode([
                        'status' => 'Success',
                        'message' => 'SuccessFully Inserted'
                    ]);
                }
            } else {
                return json_encode([
                    'status' => 'Error',
                    'message' => 'Login First'
                ]);
            }
        } catch (Exception $th) {
            $conn->close();
            return json_encode([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }
    public function getData($page = 1, $limit = 7, $search = '')
    {
        global $conn;
        try {
            if ($this->checkifUserExist($_SESSION['name'], $_SESSION['email'])) {
                $offset = ($page - 1) * $limit;
                $searchParam = "%" . $conn->real_escape_string($search) . "%";

                $query = $conn->prepare("SELECT * FROM contacts_tbl WHERE user_id = ? AND (name LIKE ? OR company LIKE ? OR phone LIKE ? OR email LIKE ?) LIMIT ?, ?");
                $query->bind_param('issssii', $this->getId(), $searchParam, $searchParam, $searchParam, $searchParam, $offset, $limit);
                $query->execute();
                $result = $query->get_result();
                $data = array();
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }

                    $countQuery = $conn->prepare("SELECT COUNT(*) as total FROM contacts_tbl WHERE user_id = ? AND (name LIKE ? OR company LIKE ? OR phone LIKE ? OR email LIKE ?)");
                    $countQuery->bind_param('issss', $this->getId(), $searchParam, $searchParam, $searchParam, $searchParam);
                    $countQuery->execute();
                    $countResult = $countQuery->get_result();
                    $totalRecords = $countResult->fetch_assoc()['total'];

                    return json_encode([
                        'status' => 'Success',
                        'data' => $data,
                        'totalRecords' => $totalRecords
                    ]);
                }
            } else {
                return json_encode([
                    'status' => 'Error',
                    'message' => 'Login First'
                ]);
            }
        } catch (Exception $th) {
            $conn->close();
            return json_encode([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }
    public function getSpecificData($id)
    {
        global $conn;
        try {
            $query = $conn->prepare("SELECT * FROM contacts_tbl WHERE id= ?");
            $query->bind_param('i', $id);
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            return json_encode([
                'status' => 'Success',
                'data' => $row
            ]);
        } catch (Exception $th) {
            $conn->close();
            return json_encode([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }


    public function checkifUserExist($name, $email)
    {
        if (isset($name) && isset($email)) {
            return true;
        } else {
            return false;
        }
    }
    public function getId()
    {
        global $conn;
        try {
            $query = $conn->prepare("SELECT id FROM users_tbl WHERE name= ? AND email=?;");
            $query->bind_param('ss', $_SESSION['name'], $_SESSION['email']);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows == 0) {
                $query->close();
                $conn->close();
                return json_encode([
                    'status' => 'Error',
                    'message' => 'Email is already Exists'
                ]);
            } else {
                $row = $result->fetch_assoc();
                return $row['id'];
            }
        } catch (Exception $th) {
            $conn->close();
            return json_encode([
                'status' => 'Error',
                'message' => $th->getMessage()
            ]);
        }
    }
}