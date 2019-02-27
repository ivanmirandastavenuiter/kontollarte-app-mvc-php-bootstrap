# Kontollarte Art App

A simple and useful app to manage art jobs and contact with the art world professionals.

__HEY!__: this is the local version. To check it on the internet, click here: http://kontollarte.epizy.com/index.php?mod=user&op=login

## Some pics of the app 

![pic1](https://github.com/ivanmirandastavenuiter/kontollarte-php/blob/master/pics/1.PNG)

![pic2](https://github.com/ivanmirandastavenuiter/kontollarte-php/blob/master/pics/2.PNG)

![pic3](https://github.com/ivanmirandastavenuiter/kontollarte-php/blob/master/pics/3.PNG)

![pic4](https://github.com/ivanmirandastavenuiter/kontollarte-php/blob/master/pics/4.PNG)

![pic5](https://github.com/ivanmirandastavenuiter/kontollarte-php/blob/master/pics/5.PNG)

![pic6](https://github.com/ivanmirandastavenuiter/kontollarte-php/blob/master/pics/6.PNG)

![pic7](https://github.com/ivanmirandastavenuiter/kontollarte-php/blob/master/pics/7.PNG)

## App main functions

This app is organised around __five different fields__:

* __Shows__: this is the main page. It is the one where the user is redirected once is logged. It is composed of shows information, showing an image of the current event and some details; specifically __name, date and description__. This page takes the information from an exernal API, which provide one show per request info. This is built this way to avoid overloading on the page. With jQuery, repeated possible clicks of the user are controlled and prevented. It also follows a concrete logic towards database storage. At the beginning, when the user enters, there's no information on the database. If user push forwards, the logic of the program will check if there's already info in the system, otherwise it will call the API. This also makes things faster at the time of requests. It will hold a maximum of 25 request to API. Once this top is reached, requested will be made towards database. It's supposed to delete and refresh this information on each user's account, but this function has to be made yet.

* __Account__: simple, it pick the user main details. The fields are __username, name, surname, phone and email__. The user will be able to change and update his/her data at anytime. Controls are also implemented here, meaning the app will check if some name, email, username or surname are being repeated. Finally, user will also be able to delete his/her account. In this case, a modal pops up, forcing a redirect to login page.

* __Paintings__ : the page to upload the client jobs. It works dinamically, which means it will detect if there's or not paintings uploaded. It is made to load 2 jobs at first, making available a load button to extract more data. Once top is reached, this button will disappear. There's, of course, a modal for uploading. Controls are established here in many ways. It prevent about exceeds on size, repeated titles, errors on uploading or empty parameters, between others. If process ends badly, jQuery maintains modal form open to repeat the request. In case of success, modal is automatically closed and some data is refreshed. All mechanisms here are made through AJAX, avoiding unnecessary and unsightly reloadings. 

* __Galleries__: this is, with messages category, one of the special features. It recovers information about galleries through the API and it exposes the data to the user, so he/she can easily and quickly interact with a bunch of professionals in just one click. AJAX additional requests activated with bottom button brings more information in case user is interested in seeing more data. Title works dinamically, detecting if galleries have been previously stored or not.

* __Messages__: king category. It complies the objective which the app was thought for. It launches first a query to bring user stored galleries and offer them as possible contacts, organising them in checkboxes, so the user can tick them. A text area is displayed to gather message information. To implement mail function, a simple and famous library has been chosen: PHP Mailer. 

## Database structure

Firstly, you can check a brief and graphic summary about database organisation:

![database](https://github.com/ivanmirandastavenuiter/kontollarte-php/blob/master/pics/database.PNG)

As you can see in the image, it is composed of nine tables. This is the logic of how it works and how each one are thought:

* __User__: recovers user information. Central table of app.
* __Messages and receivers__: stores the details of each message the user sents. It has a relation of one to many (direction user-message). That's the reason it contains the user id as foreign key on it. On the other hend, and heading towards receivers details, a new table is made (receivers). Knowing relationship between them is many to many, an intermediate table is created. This centered taable will hold the id of the message with the id of the receiver, cause a message can be sent to many galleries. Foreign keys and primary keys can be perfectly seen on the image.
* __Shows and images__: this table stores info of the shows to complete the app and give some extra functionallity. Relation with its own images are made by another table: images. Relation one to one. Foreign key inserted on image table.
* __Paints__: user jobs. Relation respect to the user of one to many. No intermediate tables. Foreign key on paint table. Images paths stored here are saved on the server in a folder called uploads.
* __Galleries and user__: information of the galleries user stores as his/her own. Intermediate table recovers user and galleries ids to relate the data between these tables. Relation of many to many. 

## Logic - Main points

### Session control

A control of session is implemented through a class. It takes into account whether the session time has expired and extra information, like current user logged or data about galleries. 

This is the session class definition:

```php

<?php 

class Session {

    private static $instance = null;
    private static $expirationTime;

    private $userLogged = false;

    private function __construct() { }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function allowAccess() {
        $this->getUserLogged();
        $this->getExpirationTime();

        // Optional lines to check session behavior

        // echo 'Time of last action: '.self::$expirationTime.'</br>;
        // echo 'Time of inactivity: '.(time() - self::$expirationTime) / 60;

        if ((time() - self::$expirationTime) / 60 < 15
                || !$this->userLogged) {
            return true;
        } else {
            $this->kill();
        }
    }

    public function launch() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function __call($method, $parameters) {
        if (in_array($method, array('kill'))) {
            return call_user_func_array(array($this, $method), $parameters);
        }
    }

    private function kill() {
        self::$instance = null;
        $_SESSION = null;
        session_destroy();
        header('Location: index.php?mod=user&op=login');
    }

    public function setNewValue($indexName, $valueName, $serialize = false) {

        if (is_object($valueName) && !$this->userLogged && get_class($valueName) == 'User') {
            $this->setUserLogged();;
        }

        if ($serialize) {
            $_SESSION[$indexName] = serialize($valueName);
            
        } else {
            $_SESSION[$indexName] = $valueName;
        }

        $this->updateLastActivityTime();
    }

    public function getValueByIndex($indexName, $unserialize = false) {

        if ($this->checkIfIndexExists($indexName)) {

            if ($unserialize) {
                return unserialize($_SESSION[$indexName]);
            } else {
                return $_SESSION[$indexName];
            }

        }

        $this->updateLastActivityTime();
    }

    public function checkIfIndexExists($indexName):bool {

        if (isset($_SESSION[$indexName])) {
            return true;
        } else {
            return false;
        }

    }

    public function updateLastActivityTime() {
        self::$expirationTime = time();
        $_SESSION['expiration-time'] = self::$expirationTime;
    }

    private function getExpirationTime() {
        if (isset($_SESSION['expiration-time'])) {
            self::$expirationTime = $_SESSION['expiration-time'];
        }
        return self::$expirationTime;
    }

    public function setUserLogged() {
        $this->userLogged = true;
        $_SESSION['user-logged'] = $this->userLogged;
    }

    private function getUserLogged() {
        if (isset($_SESSION['user-logged'])) { 
            $this->userLogged = $_SESSION['user-logged'];
        }   
    }

}

?>

```

Session.php uses singleton pattern on building the instance. 

### Inheritance

Database.php class inherits from connection.php, leaving basic functions on parent class and making then more specific on child methods.

### API service

The API used is Artsy.net. To simplify the implementation, apitool.php has been created to execute all the methods needed: 

```php

<?php 

    // Class definition
    class ApiTool {

        private const CLIENT_ID = "f48af15b3de0c1abf012";
        private const CLIENT_SECRET = "0450009deea32c3fef6ff274e9514082";
        private $token;

        // Initialize token with the constructor
        public function __construct() {
            if (is_null($this->token)) {
                $this->token = $this->getToken(self::CLIENT_ID, self::CLIENT_SECRET);
            }
        }

        // Method to obtain required token for API
        private function getToken($CLIENT_ID, $CLIENT_SECRET) {

            $postdata = array();
            $postdata['client_id'] = $CLIENT_ID;
            $postdata['client_secret'] = $CLIENT_SECRET;
    
            $cc = curl_init();
            curl_setopt($cc, CURLOPT_POST, 1); 
            curl_setopt($cc, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($cc, CURLOPT_URL, "https://api.artsy.net/api/tokens/xapp_token");
            curl_setopt($cc, CURLOPT_POSTFIELDS, $postdata);
            $result = curl_exec($cc);
    
            $json_result = json_decode($result);
            $token = $json_result->token;
            curl_close($cc);
            return $token;
        }

        // Galleries request method
        function getGalleries($quantity) {

            $gallery_url = "https://api.artsy.net/api/partners?size=".$quantity."&xapp_token=".$this->token;
			$gallery_json = file_get_contents($gallery_url);
            $gallery_array = json_decode($gallery_json, true);
            
            return $gallery_array;
        }

        // Shows request method
        function getShows($quantity) {
            
            $shows_url = "https://api.artsy.net/api/shows?status=current&size=".$quantity."&xapp_token=".$this->token;
			$shows_json = file_get_contents($shows_url);
            $shows_array = json_decode($shows_json, true)['_embedded']['shows'];

            return $shows_array;
        }

        function getShowsThroughOffset($quantity, $offset) {
            
            $shows_url = "https://api.artsy.net/api/shows?status=current&offset=".$offset."&size=".$quantity."&xapp_token=".$this->token;
			$shows_json = file_get_contents($shows_url);
            $shows_array = json_decode($shows_json, true)['_embedded']['shows'];

            return $shows_array;
        }

        // Shows's images request method
        function getShowImage($show_id) {

            $image_url = "https://api.artsy.net/api/images?show_id=".$show_id."&xapp_token=".$this->token;
            $image_json = file_get_contents($image_url);
            $image_data = array();
                if (!empty(json_decode($image_json, true)['_embedded']['images']) &&
                    !is_null(json_decode($image_json, true)['_embedded']['images'][0]['original_height']) &&
                    !is_null(json_decode($image_json, true)['_embedded']['images'][0]['original_width'])) {

                    $image_data = [
                                    'link' => json_decode($image_json, true)['_embedded']['images'][0]['_links']['thumbnail']['href'],
                                    'height' => json_decode($image_json, true)['_embedded']['images'][0]['original_height'],
                                    'width' => json_decode($image_json, true)['_embedded']['images'][0]['original_width']
                    ];

                } else {
                    $image_data = [
                        'link' => 'https://dummyimage.com/600x400/000/fff.png&text=Currently+not+available',
                        'height' => 480,
                        'width' => 720
                    ];
                }
            return $image_data;
        }

        // Shows the list of galleries
        function getGalleriesTrhoughOffset($quantity, $offsetParameter) {

            $galleries_array = '';
            $galleries_url = "https://api.artsy.net/api/partners?offset=".$offsetParameter."&size=".$quantity."&xapp_token=".$this->token;
            $galleries_json = file_get_contents($galleries_url);
            $galleries_array = json_decode($galleries_json, true)['_embedded']['partners'];
            
            return $galleries_array;
        }

    }

?>

```

### Transferring and modifying data with jQuery

In the project, jQuery has been extensively used to modify and pass parameters between bootstrap modals. Some examples are shown here:

#### Passing parameters on e.preventDefault()

```javascript

  $('#message-form').submit(function(e) {

      e.preventDefault();

      var selectedPictures = [];
      $('.custom-control-input.usr-pics').each(function() {
          if (this.checked) {
              inputData = this;
              $.each(data.pictures, function() { 
                  if (this.id == inputData.dataset.paintId) {
                      selectedPictures.push(this);
                  }
              });
          }
      })

      $('input#message-content').attr('value', JSON.stringify(data.messageBody));
      $('input#receivers').attr('value', JSON.stringify(data.receivers));
      $('input#pictures').attr('value', JSON.stringify(selectedPictures));

      this.submit();

  })


```

#### Modifying parameter values

```javascript

  $('#confirm-message .modal-body .message-content')[0].innerHTML = '';
  $('#confirm-message .modal-body .receivers-content ul').children().remove();
  $('#confirm-message .modal-body .jobs-content').children().remove();

  $('#confirm-message .modal-body .message-content').append(data.messageBody);

  $.each(data.receivers, function() {
  $('#confirm-message .modal-body .receivers-content ul')
          .append(
              '<li>' + this.name + ' - ' + this.email + '</li>');
  });

  $.each(data.pictures, function() {
  $('#confirm-message .modal-body .jobs-content')
          .append(
              "<p><strong>" + this.name + "</strong></p>" + 
              "<img src='" + this.image + "' width='450' height='400'>" +
              "<div class='custom-control custom-checkbox'>" 
                  + "<input type='checkbox' data-paint-id='" + this.id + "' class='custom-control-input usr-pics' id='paint" + this.id + "'>"
                  + "<label class='custom-control-label' for='paint" + this.id + "'>Include this job</label>"
              + "</div>");
  });

```

#### Enabled/Disabled buttons

Send button in message section will only be available only in the case some galleries are found. Otherwise, it won't be clickable.

![pic8](https://github.com/ivanmirandastavenuiter/kontollarte-php/blob/master/pics/8.PNG)

### Use of AJAX

AJAX has been also deeply used in this app to load or refresh data from the server, for example. Most significant request is one that implements a recursive ajax request, making one into success porperty of the previous one. It is the next one:

```javascript

$.ajax({
    url: "index.php",
    type: "POST",
    data:  new FormData(this),
    contentType: false,
            cache: false,
    processData:false,
    beforeSend : function() {
        $("#preview").fadeOut();
        $("#err").fadeOut();
    },
    success: function(data) {

        var imgData = JSON.parse(data).imgTag;
        var resultResponse = JSON.parse(data).resultResponse;

        console.log(imgData, resultResponse);

        if (imgData != '') {
            $("#preview").html(imgData).fadeIn();
        }

        switch(resultResponse) {
            case 'forbidden-type':
                $('#forbidden-type').modal('show');
              break;
            case 'upload-success':
                uploadSuccess = true;
                $('#upload-success').modal('show');
              break;
            case 'upload-exists':
                $('#upload-exists').modal('show'); 
              break;
            case 'forbidden-size':
                $('#forbidden-size').modal('show');
              break;
            case 'forbidden-extension':
                $('#forbidden-extension').modal('show');
              break;
            case 'empty-parameters':
                $('#empty-parameters').modal('show');
              break;
          }

        var totalImages = parseFloat($('#main-wrapper').attr('data-total-images'));
        var imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));
        imagesToLoad = totalImages - imagesLoaded;

        $("#upload-picture-form")[0].reset(); 

        $.ajax({
            method  : "GET",
            url     : "index.php",
            contentType: 'html',
            data: { "mod" : "picture", 
                    "op" : "reloadPictures",
                    "imagesToLoad" : imagesToLoad,
                    "imagesLoaded" : imagesLoaded },
            success : function(data) {

                if (uploadSuccess) {

                    $('#main-wrapper')[0].innerHTML += data;

                    var totalImages = parseFloat($('#main-wrapper').attr('data-total-images'));
                    var imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));

                    $('#main-wrapper').attr('data-total-images', parseFloat(totalImages) + 1);
                    $('#main-wrapper').attr('data-loaded-images', parseFloat(imagesLoaded) + 1);

                    totalImages = parseFloat($('#main-wrapper').attr('data-total-images'));  
                    imagesLoaded = parseFloat($('#main-wrapper').attr('data-loaded-images'));  

                    $('#painting-notfound-title').attr('style', 'display: none'); 

                    console.log('Computed value in recursive ajax for: ')
                    console.log('Images loaded: ' + imagesLoaded)
                    console.log('Total images: ' + totalImages)

                }

            },
            error : function(e) {
                $("#err").html(e).fadeIn();
            }
        });
    },
    error: function(e) {
        $("#err").html(e).fadeIn();
    }                     
});

```

### MVC orientation

Project follows MVC pattern and it is organised based on its rules. The main controller manages the way app flows, sending to one or another operation depending on the the action requested in each case. 

```php

<?php 

    require_once 'C:\xampp\htdocs\MVC\resources\php\session.php';
    
    $userSession = Session::getInstance();
    $userSession->launch();
    
    if ($userSession->allowAccess()
            && $userSession->checkIfIndexExists('current-user')) {
        $mod = $_GET['mod']??'show';
        $op = $_GET['op']??'display';
    } else {
        $mod = $_GET['mod']??'user';
        $op = $_GET['op']??'login';
    }

    if (isset($_POST['mod'], $_POST['op'])) {
        $mod = $_POST['mod'];
        $op = $_POST['op'];
    }

    $controllerName =  $mod.'Controller';

    require_once 'src/controllers/'.$controllerName.'.php';

    $controller = new $controllerName();
    if (method_exists($controller, $op)) $controller->$op();

?>


```

### Styles - CSS

Styles features still have to be implemented. At the moment is a bit ugly. It will be done soon... :expressionless:

