<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript" src="resources\js\messages-script.js"></script>
    <link rel="stylesheet" href="resources\css\messages.css" class="css">
    <title>Messages</title>
</head>
<body>

    <div class="result-response" data-result-response="none"></div>

    <?php  

        require_once 'C:\xampp\htdocs\MVC\resources\php\navbar.php';
        require_once 'C:\xampp\htdocs\MVC\resources\php\messages\message.messages.php';

        if (isset($resultResponse)) {

            echo "<script>";
            echo "$('.result-response').attr('data-result-response', '$resultResponse');";
            echo "</script>";

        }

    ?>

    <div class="container-fluid main-container">

        <div class="col-12" id="message-view-title">
            <h2>Messages</h2>
        </div>

        <div class="container-fluid table-container">

            <div class="col-12" id="message-table-title">
                <h3>Messages sent</h3>
            </div>

            <?php if (!empty($messagesList)) { ?>

            <table class="table table-borderless table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Content</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>

                <?php 
                
                $index = 1;
                foreach ($messagesList as $currentMessage) { 

                ?>
                    <tr>
                        <th scope="row"><?=$index?></th>
                        <td><?=$currentMessage->getName()?></td>
                        <td><?=$currentMessage->getEmail()?></td>
                        <td><?=$currentMessage->getBody()?></td>
                        <td><?=$currentMessage->getDate()?></td>
                    </tr>

                <?php $index++; 
                } ?>

                </tbody>
            </table>

            <?php } else {  ?>

                <div class="col-12" id="message-notfound-title">
                    <h4>No messages have been found on database yet</h4>
                </div>

            <?php } ?>
        
        </div>

        <div class="container-fluid messages-container">

        <form method="get">
            <div class="form-row">

                <div class="col col-sm-12 col-md-6 col-lg-6 left-side">

                    <div class="container-fluid message-box-container">

                        <h3>Communicate with the world and show your works!</h3>

                        <div class="form-group">
                            <label for="comment">Write a message:</label>
                            <textarea class="form-control" rows="5" id="message-body" name="message-body"></textarea>
                        </div>

                        <div class="message-btn-container">
                            <input type="hidden" name="mod" value="message">
                            <input type="hidden" name="op" value="handleMessageRequest">
                            <button type="button" class="btn btn-danger submit-btn">Send</button>
                        </div>

                    </div>
                
                </div>

                <div class="col col-sm-12 col-md-6 col-lg-6 right-side">

                    <div class="container-fluid galleries-checkbox-container">

                        <?php if (!empty($galleriesList)) { ?>

                        <h3>Check the galleries you want to contact with!</h3>

                        <div class="radio-btn-container">

                            <?php foreach($galleriesList as $currentGallery) { ?>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" 
                                           class="custom-control-input" 
                                           id="customCheck<?= $currentGallery->getId() ?>"
                                           name="galleriesList[]" 
                                           value="<?= $currentGallery->getId() ?>">
                                    <label class="custom-control-label" 
                                           for="customCheck<?= $currentGallery->getId() ?>">
                                                <?= $currentGallery->getName() ?> - <?= $currentGallery->getEmail() ?>
                                    </label>
                                </div>

                            <?php } ?>

                        </div>

                        <?php } else { ?>

                        <h3>No galleries have been found on the database yet</h3>

                        <?php } ?>

                    </div>
                
                </div>
            
            </div>

        </form>

        </div> 
    
    </div> 
    
</body>
</html>