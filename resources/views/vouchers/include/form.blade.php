<table class="table">
    <tr>
        <td class="align-middle">QTY</td>
        <td>
            <div><input class="form-control " type="number" name="qty" min="1" max="500" value="1"
                    required></div>
        </td>
    </tr>
    <tr>
        <td class="align-middle">Server</td>
        <td>
            <select class="form-control " name="server" required>
                <option>all</option>
                <?php $TotalReg = count($srvlist);
                for ($i = 0; $i < $TotalReg; $i++) {
                    echo '<option>' . $srvlist[$i]['name'] . '</option>';
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="align-middle">User mode</td>
        <td>
            <select class="form-control " onchange="defUserl();" id="user" name="user" required>
                <option value="up">Username & Password</option>
                <option value="vc">Username = Password</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="align-middle">User length</td>
        <td>
            <select class="form-control " id="userl" name="userl" required>
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
                placeholder="Optional" value=""></td>
    </tr>
    <tr>
        <td class="align-middle">Character</td>
        <td>
            <select class="form-control " name="char" required>
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
            <select class="form-control " id="uprof" name="profile" required>
                <?php
                $TotalReg = count($getprofile);
                for ($i = 0; $i < $TotalReg; $i++) {
                    echo '<option>' . $getprofile[$i]['name'] . '</option>';
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="align-middle">Time Limit</td>
        <td><input class="form-control " type="text" size="4" autocomplete="off" name="timelimit"
                value="" placeholder="Optional"></td>
    </tr>
    <tr>
        <td class="align-middle">Data Limit</td>
        <td>
            <div class="input-group">
                <input class="group-item group-item-l form-control" type="number" min="0" max="9999"
                    name="datalimit" value="" placeholder="Optional">
                <div class="input-group-2">
                    <select class="group-item group-item-r form-control" name="mbgb">
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
                placeholder="Optional" name="adcomment" value=""></td>
    </tr>
    <tr>
        <td colspan="4" class="align-middle w-12" id="GetValidPrice">
        </td>
    </tr>
</table>


@push('js')
    <script>
        function defUserl() {
            var e = document.getElementById("user").value,
                t = document.getElementById("num").style,
                n = document.getElementById("lower").style,
                l = document.getElementById("upper").style,
                o = document.getElementById("upplow").style,
                i = document.getElementById("lower1").style,
                d = document.getElementById("upper1").style,
                a = document.getElementById("upplow1").style,
                c = document.getElementById("mix").style,
                m = document.getElementById("mix1").style,
                s = document.getElementById("mix2").style;

            if ("up" === e) {
                $("select[name=userl] option:first").html("4");
                $("select[name=char] option:first").html("Random abcd");
                n.display = "block";
                l.display = "block";
                o.display = "block";
                i.display = "none";
                d.display = "none";
                a.display = "none";
                t.display = "none";
                c.display = "block";
                m.display = "block";
                s.display = "block";
            } else if ("vc" === e) {
                $("select[name=userl] option:first").html("8");
                $("select[name=char] option:first").html("Random abcd2345");
                n.display = "none";
                l.display = "none";
                o.display = "none";
                i.display = "block";
                d.display = "block";
                a.display = "block";
                t.display = "block";
                c.display = "block";
                m.display = "block";
                s.display = "block";
            }
        }
    </script>
@endpush
