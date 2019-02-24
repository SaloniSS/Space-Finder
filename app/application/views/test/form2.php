<!DOCTYPE html>
<html>
    <head>
        <title>SpaceFinder Rooms</title>
        <?= style_link_tag('form') ?>
    </head>

    <body id="form">
        <form id="form2" method="POST" action="store">

            <h1>SpaceFinder</h1>

            <span class="field">
                <label>Number of people</label>
                <span><input type="number" name="numPeople"></span>
            </span>
            
            <span class="field">
                <label>Activity</label>
                <span><input type="radio" name="activity" value="0" checked><label>Studying</label></span>
                <span><input type="radio" name="activity" value="1"><label>Recreation</label></span>
            </span>
            
            <span class = "field">
                <label>Name of group</label>
                <span><input type="text" name="groupName"></span>
            </span>

            <span class = "field">
                <label>Description</label>
                <span><input type="text" name="desc"></span>
            </span>

            <span class = "field">
                <label>Class code tag</label>
                <span><input type="text" name="classTag"></span>
            </span>

            <span class = "field">
                <label>Activity tag</label>
                <span><input type="text" name="activityTag"></span>
            </span>

            <span class = "field">
                <label>Noise level</label>
                <span><input type="radio" name="noiseLvl" value="0" checked><label>High</label></span>
                <span><input type="radio" name="noiseLvl" value="1"><label>Medium</label></span>
                <span><input type="radio" name="noiseLvl" value="2"><label>Low</label></span>
            </span>

            <input type="submit" name="" value="Next">

        </form>

            <?= script_tag('form') ?>

    </body>
</html>