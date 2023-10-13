<div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="text-primary fw-bold m-0"> Manual Input </h5>
</div>

<div class="card-body">
    <form action="reports.php" method="post">
        <h4> Enter your records for: </h4>
        <div style="text-align:center">
            <input type="date" name="date" required>
        </div>
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td> Hours </td>
                        <td><input type="number" name="hours" value="0"></td>
                    </tr>
                    <tr>
                        <td> Return Visits </td>
                        <td><input type="number" name="rv" value="0"></td>
                    </tr>
                    <tr>
                        <td> Placements </td>
                        <td><input type="number" name="placements" value="0"></td>
                    </tr>
                    <tr>
                        <td> Bible Studies </td>
                        <td><input type="number" name="bs" value="0"></td>
                    </tr>
                    <tr>
                        <td> Video Showings </td>
                        <td><input type="number" name="video" value="0"></td>
                    </tr>
                    <tr>
                        <td> LDC Hours </td>
                        <td><input type="number" name="ldc" value="0"></td>
                    </tr>
                </tbody>
            </table>
            <div style="text-align:center">
                <label for="notes"> Notes: </label>
                <textarea rows="4" cols="auto" name="notes"></textarea>
                <button id="greenbutton" type="submit"> Update Records </button>
            </div>
            
        </div>
    </form> 
</div>
