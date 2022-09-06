<?php
include 'bd_login_info.php';
session_start();

try {
    $conn= new PDO($attr,$user,$pass,$opts);
}
catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

function queryMysql($query){
    global $conn;
    return $conn->query($query);
}

//Crud des tables
/* User */
function createUser($username, $email, $password, $role= null){

    global $conn;
    $users = getUsers();
    if ($users == null){
        $role = "ADMIN";
    } else {
        $role = "USER";
    }
//    var_dump($role);

    $reqSql = "INSERT INTO user(username, email, password, role ) 
                VALUE(:username, :email, :password, :role )";
    $statement = $conn->prepare($reqSql);
    $statement->execute([
        ':email' => $email,
        ':username' => $username,
        ':password' => $password,
        ':role'=> $role
    ]);

    return ["insert_status" => 200];


}

function getUsers(){
    $reqSql = "SELECT * FROM user";
    return queryMysql($reqSql)->fetchAll();
}

function readUser($email, $password){
    $reqSql = "SELECT * FROM user WHERE email ='$email' AND password='$password'";
    $user = queryMysql($reqSql);
    return queryMysql($reqSql);

}

function userLogin($email, $password){
   $user = readUser($email, $password);

   if ($user->rowCount() == 0){
//       var_dump('bug');
        return ["error"=>"Utilisateur ou mot de passe invalide"];
   } else {
        $userData = $user->fetch();
//        var_dump($userData);

        $_SESSION['user'] = [
            'id'       => $userData['id'],
            'username' => $userData['username'],
            'email'    => $userData['email'],
            'role'     => $userData['role']
        ];

        return [
            "status_code" => 200,
            "user" => [
                'id'       => $userData['id'],
                'username' => $userData['username'],
                'email'    => $userData['email'],
                'role'     => $userData['role']
                ]
            ];
   }

}

function updateUser($username, $email, $password, $role, $userID){
    $reqSql ="UPDATE user SET username='$username', email='$email', password='$password', role='$role' WHERE id='$userID'";
    queryMysql($reqSql);
}

function deleteUser($userId){
    $reqSql = "DELETE FROM user WHERE id='$userId'";
    queryMysql($reqSql);
}

/* Category */


function createCategory($name){
    global $conn;
    $reqSql ="INSERT INTO category(name) VALUE(:name)";
    $statement = $conn->prepare($reqSql);
    $statement->execute([
        ':name'=> $name
    ]);
}

function readCategory($categoryId){
    $reqSql = "SELECT * FROM category WHERE id='$categoryId'";
     return queryMysql($reqSql);
}

function updateCategory($name, $categoryId){
    $reqSql ="UPDATE category SET name='$name' WHERE id='$categoryId'";
    queryMysql($reqSql);
}

function deleteCategory($categoryId){
    $reqSql = "DELETE FROM category WHERE id='$categoryId'";
    queryMysql($reqSql);
}

/* Post */

function getAllPosts(){
    $reqSql = "SELECT * FROM post";
    return queryMysql($reqSql)->fetchAll();
}

function getPost($postId){
    $reqSql = "SELECT * FROM post WHERE id='$postId'";
    return queryMysql($reqSql)->fetch();
}

function updatePost($image, $title, $meta_desc, $content, $postID){
    $reqSql ="UPDATE post SET image='$image', title='$title', meta_desc='$meta_desc', content='$content'  WHERE id='$postID'";
    queryMysql($reqSql)->execute();
}

function deletePost($postID){
    $reqSql ="DELETE FROM post WHERE id='$postID'";
    queryMysql($reqSql)->execute();
}

/* review */
function getReviewFromPost($post_id){
    $reqSql ="SELECT * FROM review WHERE post_id= '$post_id'";
    return queryMysql($reqSql)->fetchAll();
}

function getReviewFromUser($user_id){
    $reqSql ="SELECT * FROM review WHERE post_id= '$user_id'";
    return queryMysql($reqSql)->fetchAll();
}

function getReview($reviewID){
    $reqSql = "SELECT * FROM review WHERE id='$reviewID'";
    return queryMysql($reqSql)->fetch();
}

function updateReview($content){
    $reqSql = "UPDATE review SET content= '$content'";
    return queryMysql($reqSql)->execute();
}

