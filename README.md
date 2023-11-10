## About
Question-Answer Application is like Stackoverflow which lets users to ask tech question, and let the others give you voting for your question

## How to run the app in your local machine
- Clone the project
- Run "composer update" in your terminal
- Create .env file
- Run "php artisan key:genereate" in your terminal
- Create database in phpmyadmin and add it in your .env file
- Run "php artisan migrate:fresh --seed" in your terminal
- Use this credentials to access app as admin user (email: admin@website.com, password: 'password')
- Use this credentials to access app as normal user (email: test@website.com, password: 'password')

## Question-Answer Application with the following features:
- Question Voting (You cannot vote your own questions)
- Receiving an email notification after your question receives an answer
- Questions limit per day, If you reach the limit, the question form will be locked till tomorrow
- Report any an inappropriate questions (the admin will receive an email notification)
- Admin can lock or unlock questions 
- Questions are attached with tags
- Counter for question views (depends on session)
- Every user has a public profile with the questions he asked
- Search System
- Admin dashboard with website statistics
