$(document).ready(function() { 

    function loadNextShowImage() {

	  var position = $('.slider-container').data('position');

	  var img = $('.carousel-item > img');

      $.ajax({
          method  : "GET",
          url     : "index.php",
          dataType: "json",
          data: { "mod" : "show", "op" : "getNextSliderImage", "position" : position },
          success : function(data) {  

            if (!data.error) {

              var showData = data.showData;
              var dimensions = fixMaxWidthAndHeight(showData.imgData.height, showData.imgData.width);

              // Image
              img.attr('src', showData.imgData.link);
              img.attr('height', dimensions.height);
              img.attr('width', dimensions.width);

              // Dates
              $('.date-paragraph').children().remove();
              $('.date-paragraph').append(
                formatDates(showData.startingDate, showData.endingDate)
              );
              
              // Name
              $('.name-paragraph')[0].textContent = showData.name;

              // Description
              $('.description-paragraph')[0].textContent = showData.description;

              // Position increased value
              $('.slider-container').data('position', data.newPosition);

            }
          },
          error : function(jqXHR, textStatus, errorThrown) {

             console.log('Response: ' + jqXHR)
             console.log('Type of error: ' + textStatus);
             console.log('Exception: ' + errorThrown);

          }
        }) ;

    }

    function loadPrevShowImage() {

      var position = $('.slider-container').data('position');

      var img = $('.carousel-item > img');

      $.ajax({
          method  : "GET",
          url     : "index.php",
          dataType: "json",
          data: { "mod" : "show", "op" : "getPreviousSliderImage", "position" : position },
          success : function(data) {

            var showData = data.showData;
            var dimensions = fixMaxWidthAndHeight(showData.imgData.height, showData.imgData.width);

            // Image
            img.attr('src', showData.imgData.link);
            img.attr('height', dimensions.height);
            img.attr('width', dimensions.width);

            // Dates
            $('.date-paragraph'). children().remove();
            $('.date-paragraph').append(
            formatDates(showData.startingDate, showData.endingDate)
            );
            
            // Name
            $('.name-paragraph')[0].textContent = showData.name;

            // Description
            $('.description-paragraph')[0].textContent = showData.description;

            // Position increased value
            $('.slider-container').data('position', data.newPosition);

          },
          error : function(jqXHR, textStatus, errorThrown) {

            console.log('Response: ' + jqXHR)
            console.log('Type of error: ' + textStatus);
            console.log('Exception: ' + errorThrown);

          }
      }) ;


    }

    $('.carousel-control-prev').click(function() {

        checkShowsOnDatabase();

        var databaseEntries = $('.slider-container').attr('data-database');
        if (databaseEntries == 'true') {

          $('.gif-container').attr('style', 'display: block');
          $('.carousel').attr('style', 'display: none');
          $('.info-container').attr('style', 'display: none');

          var button = $(this);

          if (button.hasClass('disabled')) {
            return;
          } else {
            loadPrevShowImage();
            button.addClass('disabled');
          }

          setTimeout(function() {
            button.removeClass('disabled');
            $('.gif-container').attr('style', 'display: none');
            $('.carousel').attr('style', 'display: block');
            $('.info-container').attr('style', 'display: block'); 
          }, 3000);

        } else {
            $('#empty-shows').modal('show');
        }

    });

    $(".carousel-control-next").click(function() {

        $('.gif-container').attr('style', 'display: block');
        $('.carousel').attr('style', 'display: none');
        $('.info-container').attr('style', 'display: none');

        var button = $(this);

        if (button.hasClass('disabled')) {
          return;
        } else {
          loadNextShowImage(); 
          button.addClass('disabled');
        }

        setTimeout(function() {
          button.removeClass('disabled');
          $('.gif-container').attr('style', 'display: none');
          $('.carousel').attr('style', 'display: block');
          $('.info-container').attr('style', 'display: block');
        }, 3000);
      
    }) ;

    function checkShowsOnDatabase() {

          $.ajax({
            method  : "GET",
            async: false,
            url     : "index.php",
            dataType: "text",
            data: { "mod" : "show", "op" : "getAllShows" },
            success : function(data) {

              if (data == 0) {
                $('.slider-container').attr('data-database', 'false');
              } else {
                $('.slider-container').attr('data-database', 'true'); 
              }
                
            },
            error : function(jqXHR, textStatus, errorThrown) {

              console.log('Response: ' + jqXHR)
              console.log('Type of error: ' + textStatus);
              console.log('Exception: ' + errorThrown);

            }
        }) ;

    }

    function formatDates(startingDate, endingDate) {
        $('.date-paragraph')[0].textContent = '';
        return "<div class='dates-container'>" + 
                  "<b>Starting date:</b> " + startingDate + "</br>" +
                  "<b>Ending date:</b> " + endingDate +
               "</div>";
    }

    function fixMaxWidthAndHeight(height, width) {

      var dimensions = [];

      if (height > 450) dimensions['height'] = 450; else dimensions['height'] = height;
      if (width > 720) dimensions['width'] = 720; else dimensions['width'] = width;

      return dimensions;

    }

}) ;