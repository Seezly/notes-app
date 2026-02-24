# Notes App

This is a project I've made with the end of practicing the basics of pure PHP, and make a full-stack project with all the features of a real app, but more simple. Also, this is a project I thought of to present it in my final stage in Diverta's Global Internship. You would find JWT Auth, MVC architecture approach, DB indexes, unique and foreign keys, role based permissions, soft deletes in database, logs for admin audits, simple rate-limiting and an admin dashboard with statistics (complex SQL queries).

## Why?

Well, the reason behind this project was to actually get my hands full with the experience of trying to make a project closest to a real app. Trying to follow good practices, implementing things I've never had the chance of implementing on previous projects, and coding with a OOP approach. This project is the proof to Diverta's team of my knowledge and the desire of doing great things, do things better, and become a better engineer.

## Tech stack

As for the tech stack, I choose vanilla PHP, MySQL, HTML, TailwindCSS and vanilla JavaScript. The reason of choosing for this project vanilla PHP over other languages (and frameworks) was to refresh and prove the core knowledge of the language itself. As for I choose specifically PHP, it has to do with my experience and how close this language is with me. So, let's list it:

- PHP
- MySQL
- TailwindCSS
- HTML
- JavaScript

## How can I install (and test) this project?

Ok, so, first you have to clone this repo using the terminal and running the following commands:

`git clone https://github.com/Seezly/notes-app.git`

Then, please do the following:

`cd notes-app` (this will enter the repos directory)

`mv .env.example .env` (this will copy the .env.example file to .env so you can modify all the env vars)

`composer install` (this will install all the dependencies)

**Please make sure you have a MySQL server instance running when prompting this command**
At the root directory of this repo is a file named `db.sql`. Please import it on your favorite Database Administration Tool.

`composer run dev` (this will turn up the server locally)

If you want to run tests, please do:

`composer run tests`
