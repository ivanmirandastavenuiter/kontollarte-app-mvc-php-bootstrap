# Kontollarte Art App

A simple and useful app to manage art jobs and contact with the art world professionals.

## App main functions

This app is organised around __five different fields__:

* __Shows__: this is the main page. It is the one where the user is redirected once is logged. It is composed of shows information, showing an image of the current event and some details; specifically __name, date and description__. This page takes the information from an exernal API, which provide one show per request info. This is built this way to avoid overloading on the page. With jQuery, repeated possible clicks of the user are controlled and prevented. It also follows a concrete logic towards database storage. At the beginning, when the user enters, there's no information on the database. If user push forwards, the logic of the program will check if there's already info in the system, otherwise it will call the API. This also makes things faster at the time of requests. It will hold a maximum of 25 request to API. Once this top is reached, requested will be made towards database. It's supposed to delete and refresh this information on each user's account, but this function has to be made yet.

* __Account__: simple, it pick the user main details. The fields are __username, name, surname, phone and email__. The user will be able to change and update his/her data at anytime. Controls are also implemented here, meaning the app will check if some name, email, username or surname are being repeated. Finally, user will also be able to delete his/her account. In this case, a modal pops up, forcing a redirect to login page.

* __Paintings__ : the page to upload the client jobs. It works dinamically, which means it will detect if there's or not paintings uploaded. It is made to load 2 jobs at first, making available a load button to extract more data. Once top is reached, this button will disappear. There's, of course, a modal for uploading. Controls are established here in many ways. It prevent about exceeds on size, repeated titles, errors on uploading or empty parameters, between others. If process ends badly, jQuery maintains modal form open to repeat the request. In case of success, modal is automatically closed and some data is refreshed. All mechanisms here are made through AJAX, avoiding unnecessary and unsightly reloadings. 

* __Galleries__: this is, with messages category, one of the special features. It recovers information about galleries through the API and it exposes the data to the user, so he/she can easily and quickly interact with a bunch of professionals in just one click. AJAX additional requests activated with bottom button brings more information in case user is interested in seeing more data.


