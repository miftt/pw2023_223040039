<?php
require 'config.php';

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {;
        $rows[] = $row;
    }
    return $rows;
}

function getUsers()
{
    global $conn;
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $users;
}

function getProducts()
{
    global $conn;
    $query = "SELECT m.*, c.category_name FROM Menu m
              LEFT JOIN Menu_Category mc ON m.menu_id = mc.menu_id
              LEFT JOIN Category c ON mc.category_id = c.category_id";
    $result = mysqli_query($conn, $query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $products;
}


// Fungsi untuk mendapatkan data kategori dari database
function getCategories()
{
    global $conn;
    $query = "SELECT * FROM Category";
    $result = mysqli_query($conn, $query);
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $categories;
}

function getOrderDetails()
{
    global $conn;
    $query = "SELECT * FROM order_detail";
    $result = mysqli_query($conn, $query);
    $orderDetail = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $orderDetail;
}
