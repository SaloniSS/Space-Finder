<!DOCTYPE html>
<html>
    <head>
        <title>SpaceFinder Rooms</title>
        <?= style_link_tag('form') ?>
    </head>

    <body id="form">
        <form id="form1" method="POST" action=/test/form2>

            <h1>SpaceFinder</h1>

            <span class="field">
                <label>Room privacy</label>
                <span><input type="radio" name="privacy" value="0" checked><label>Open</label></span>
                <span><input type="radio" name="privacy" value="1"><label>Closed</label></span>
            </span>
            
            <input type="submit" name="" value="Next">

        </form>
    </body>
</html>