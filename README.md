# Hotel application

A simple web application for searching and booking rooms

## Table of Contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#setup)
* [More details](#more-details)


## General info

The current project aimed at developing a fully functional application about booking a hotel room. It includes many modern technologies and it is also secured to protect the user and the application from attacks. In the app you can create a user, search for available hotel rooms and make a booking.

## Technologies

* HTML5
* CSS3
* JAVASCRIPT (mostly vanilla js)
* PHP (8 version)
* SQL

## Setup

To launch the application except the above technologies you need to setup the db file to phpmyadmin or similar software. The external files included in the project or they are imported.

## More details

The application is seperated into six web pages the index, login, register, list, room and profile.
- index file: it's the basic web page of the application which the user can select between four options to search a room. The options are to select city, room type, check-in and check-out, the obligatory options to continue are all except the room type.

- login file: at that web page if you have already an account you can login to the app with your email and password.

- register file: in that web page you can create an account by filling the obligatory fields of full name, email and password.

- list file: you can see the results of the data form. A list of available rooms will be displayed on user. Besides that there is an additional form that the user can fill in to find a specific type of room. The form has options of count of guests, room type, city, range value of money, check-in and check-out. You can fill in the form as you like and then you will see the results. If no room is available a message is displayed.

- room file: here you can see more details about the room and you can book the room for the selected days. Also there is a map which you can see the location of the hotel (there is a small bug or wrong implementation by me the map is not resizing correctly, to fix it resize the page once). At the bottom you will see a review form that a user can leave a review  (star selection and text) but only the star selection is obligatory. Lastly at the top there is a favorite button (heart) where a user can make this room favorite.

- profile file: here you can see your favorite rooms, the rooms that you have reviewed and the rooms that you have booked.

As for the web security part the app is protected from cross site request forgery and cross site scripting attacks.
To book a room you must be logged in the application, otherwise you will be directed to index page. 
