<table class="table">
    <tr>
        <td class="align-middle">Qty</td>
        <td>
            <div><input class="form-control " type="number" name="qty" min="1" max="500" value="1"
                    required="1"></div>
        </td>
    </tr>
    <tr>
        <td class="align-middle">Server</td>
        <td>
            <select class="form-control " name="server" required="1">
                <option>all</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="align-middle">User Mode</td>
        <td>
            <select class="form-control " onchange="defUserl();" id="user" name="user" required="1">
            </select>
        </td>
    </tr>
    <tr>
        <td class="align-middle">User Length</td>
        <td>
            <select class="form-control " id="userl" name="userl" required="1">
                <option>4</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="align-middle">Prefix</td>
        <td><input class="form-control " type="text" size="6" maxlength="6" autocomplete="off" name="prefix"
                value=""></td>
    </tr>
    <tr>
        <td class="align-middle">Character</td>
        <td>
            <select class="form-control " name="char" required="1">
                <option id="lower" style="display:block;" value="lower">Random abcd</option>
                <option id="upper" style="display:block;" value="upper">Random ABCD</option>
                <option id="upplow" style="display:block;" value="upplow">Random aBcD</option>
                <option id="lower1" style="display:none;" value="lower">Random abcd2345</option>
                <option id="upper1" style="display:none;" value="upper">Random ABCD2345</option>
                <option id="upplow1" style="display:none;" value="upplow">Random aBcD2345</option>
                <option id="mix" style="display:block;" value="mix">Random 5ab2c34d</option>
                <option id="mix1" style="display:block;" value="mix1">Random 5AB2C34D</option>
                <option id="mix2" style="display:block;" value="mix2">Random 5aB2c34D</option>
                <option id="num" style="display:none;" value="num">Random 1234</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="align-middle">Profile</td>
        <td>
            <select class="form-control " onchange="GetVP();" id="uprof" name="profile" required="1">
            </select>
        </td>
    </tr>
    <tr>
        <td class="align-middle">Time Limit</td>
        <td><input class="form-control " type="text" size="4" autocomplete="off" name="timelimit"
                value=""></td>
    </tr>
    <tr>
        <td class="align-middle">Data Limit</td>
        <td>
            <div class="input-group">
                <div class="input-group-10 col-box-9">
                    <input class="form-control group-item group-item-l" type="number" min="0" max="9999"
                        name="datalimit" value="">
                </div>
                <div class="input-group-2 col-box-3">
                    <select style="padding:4.2px;" class="group-item group-item-r" name="mbgb" required="1">
                        <option value=1048576>MB</option>
                        <option value=1073741824>GB</option>
                    </select>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="align-middle">Comment</td>
        <td><input class="form-control " type="text" title="No special characters" id="comment" autocomplete="off"
                name="adcomment" value=""></td>
    </tr>
    <tr>
        <td colspan="4" class="align-middle w-12" id="GetValidPrice">
        </td>
    </tr>
</table>
