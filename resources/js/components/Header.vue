<template>
    <nav>
        <div class="side-links">
            <a href="#">No mask</a>
            <ul class="list">
                <li><a class="active" href="index.html">Home</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
            <button class="search">Search</button>
            <button class="menu">Menu</button>
        </div>

    </nav>
</template>
<style>
nav {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 16px 20px 30px 20px;
    display: flex;
    align-items: center;
    transition: 0.3s ease-out;
    backdrop-filter: blur(0px) brightness(1.2);
    -webkit-backdrop-filter: blur(8px) brightness(1.2);
    text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    color: white;
    font-size: 16px;

}

a {
    color: rgb(0, 0, 0);
    text-decoration: none;

}

.list {
    list-style-type: none;
    margin-left: auto;
    display: flex;

}
</style>
