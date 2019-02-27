<!-- --------- MESSAGES --------- -->

<!-- Message stored success -->

<div class="modal" id="message-saved" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Message sent and correctly stored</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm sending message modal -->

<div class="modal fade" id="confirm-message" tabindex="-1" role="dialog" aria-labelledby="confirm-send-message-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirm-send-message-title">Confirm sending</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="get" id="message-form">

            <p>The following message will be sent:</p>   

            <p><strong>Message content: </strong></p>
            <p class="message-content"></p>

            <p><strong>List of receivers: </strong></p>
            <div class="receivers-content">
              <ul>
              </ul>
            </div>

            <p><strong>Would you like to attach some of your jobs to the mail?</strong></p>

            <p>List of personal jobs:</p>
            <div class="jobs-content">

            </div>

            <input type="hidden" name="message-content" id="message-content">
            <input type="hidden" name="receivers[]" id="receivers">
            <input type="hidden" name="pictures[]" id="pictures">
            <input type="hidden" name="mod" value="message">
            <input type="hidden" name="op" value="executeMessageRequest">

            <button type="submit" class="btn btn-warning">Confirm</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Undo</button>

        </form>

      </div>
    </div>
  </div>
</div>

<!-- Empty parameters for message -->

<div class="modal" id="empty-message-parameters" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>It seems you haven't introduced all parameters.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Message success -->

<div class="modal" id="message-sent" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Message has been successfully sent.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>