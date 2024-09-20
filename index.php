<?php

// TOP LEVEL
$page = getRequestedPage();
showResponsePage($page);


// FUNCTIONS
function getRequestedPage()
{
    $request_type = $_SERVER['REQUEST_METHOD'];
    if($request_type=='POST'){
        $requested_page = getPageFromPost('page','home');
    } else {
        $requested_page = getPageFromUrl('page', 'home');
    }
    return $requested_page;
}

function getPageFromPost($key, $default = '')
{
    if(isset($_POST[$key])){
        return $_POST[$key];
    } else {
        return $default;
    }
};

function getPageFromUrl($key, $default='')
{
    if(isset($_GET[$key])){
        return $_GET[$key];
    } else {
        return $default;
    }
};

function showResponsePage($page)
{
    showDocumentStart();
    showHeadSection();
    showBodySection($page);
    showDocumentEnd();
};

function showDocumentStart()
{
    echo '<!DOCTYPE html>
    <html>';
};

function showHeadSection()
{
    echo '<head>
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Educom Webshop Basis</title>
    </head>';
};

function showBodySection($page)
{
    showBodyStart();
    showMenu();
    showHeader();
    showContent($page);
    showFooter();
    showBodyEnd();
};

function showDocumentEnd()
{
    echo '</html>';
};

function showBodyStart()
{
    echo '<body>';
};

function showMenu ()
{
   echo 
   '<div class="navbar">
    <ul>
        <li><a href="index.php?page=home">HOME</a></li>
        <li><a href="index.php?page=about">ABOUT</a></li>
        <li><a href="index.php?page=contact">CONTACT</a></li>
        <li><a href="index.php?page=register">REGISTER</a></li>
        <li><a href="index.php?page=login">LOGIN</a></li>
    </ul>
    </div>'; 
};

function showHeader ()
{
    include 'header.php';
};


function showContent ($page)
{
    switch($page)
    {
        case 'home':
            require 'home.php';
            break;
        case 'about':
            require 'about.php';
            break;
        case 'contact':
            require 'contact.php';
            break;
        case 'register':
            require 'register.php';
            break;
        case 'login';
            require 'login.php';
            break;
        default:
            require 'home.php';
            break;
    }

};

function showFooter ()
{
    include 'footer.php';
};

function showBodyEnd ()
{
    echo '</body>';
};