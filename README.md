<h1>Pizza Catalog</h1>
<h2>Setting Up a Web-Test-App application with Docker</h2>

<p>This repository provides a Docker-based development environment for a PHP web application with MySQL database support. It includes configurations for PHP, Apache web server, MySQL database server, and phpMyAdmin.</p>

<h2>Prerequisites</h2>

<p>Make sure you have Docker and Docker Compose installed on your system.</p>

<ul>
<li><a href="https://docs.docker.com/get-docker/">Docker</a></li>
<li><a href="https://docs.docker.com/compose/install/">Docker Compose</a></li>
</ul>

<h2>Usage</h2>

<ol>
<li>Clone this repository to your local machine:</li>
<pre><code>git clone git@github.com:AlbertoHering/PizzaCatalogWebTestApp.git pizza_catalog</code></pre>

<li>Navigate to the project directory:</li>
<pre><code>cd pizza_catalog</code></pre>

<li>Start the Docker containers using Docker Compose:</li>
<pre><code>docker-compose up -d</code></pre>

<li>Access the application in a web browser:</li>
<ul>
    <li>The PHP application: <a href="http://localhost">http://localhost</a></li>
    <li>phpMyAdmin interface: <a href="http://localhost:8080">http://localhost:8080</a></li>
</ul>
</ol>

<h2>Configuration</h2>

<h3>Docker Compose Services</h3>

<ul>
<li><strong>webserver</strong>: Runs a PHP web server using the <code>php:7.4.3-apache</code> Docker image. It maps port 80 of the container to port 80 of the host machine and mounts the <code>src</code> directory as the document root.</li>

<li><strong>db</strong>: Sets up a MySQL database server using the <code>mysql:5.6</code> Docker image. It exposes port 3306 for MySQL connections and mounts an SQL initialization script (<code>init.sql</code>) into the container for database initialization.</li>

<li><strong>phpmyadmin</strong>: Deploys phpMyAdmin for convenient database management. It runs on port 8080 and depends on the <code>db</code> service.</li>
</ul>

<h3>Database Configuration</h3>

<ul>
<li><strong>MySQL Database Name</strong>: <code>db</code></li>
<li><strong>MySQL Root User</strong>: <code>root</code></li>
<li><strong>MySQL Root Password</strong>: <code>admin</code></li>
<li><strong>MySQL User</strong>: <code>admin</code></li>
<li><strong>MySQL Password</strong>: <code>admin</code></li>
</ul>

<p>
    Author: Alberto Hering
    <br/>Email: ahering@gmail.com
</p>
