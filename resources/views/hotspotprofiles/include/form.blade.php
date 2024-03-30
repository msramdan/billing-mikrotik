<table class="table">
    <tr>
        <td class="align-middle">Name</td>
        <td><input class="form-control" type="text" onchange="remSpace();" autocomplete="off" name="name" value=""
                required="1" autofocus></td>
    </tr>
    <tr>
        <td class="align-middle">Address Pool</td>
        <td>
            <select class="form-control " name="ppool">
                <option>none</option>
                <?php $TotalReg = count($getpool);
                for ($i = 0; $i < $TotalReg; $i++) {
                    echo '<option>' . $getpool[$i]['name'] . '</option>';
                }
                ?>

            </select>
        </td>
    </tr>
    <tr>
        <td class="align-middle">Shared Users</td>
        <td><input class="form-control" type="text" size="4" autocomplete="off" name="sharedusers"
                value="1" required="1"></td>
    </tr>
    <tr>
        <td class="align-middle">Rate limit [up/down]</td>
        <td><input class="form-control" type="text" name="ratelimit" autocomplete="off" value=""
                placeholder="Example : 512k/1M"></td>
    </tr>
    <tr>
        <td class="align-middle">Expired Mode</td>
        <td>
            <select class="form-control" onchange="RequiredV();" id="expmode" name="expmode" required="1">
                <option value="">Select...</option>
                <option value="0">None</option>
                <option value="rem">Remove</option>
                <option value="ntf">Notice</option>
                <option value="remc">Remove & Record</option>
                <option value="ntfc">Notice & Record</option>
            </select>
        </td>
    </tr>
    <tr id="validity" style="display:none;">
        <td class="align-middle">Validity</td>
        <td><input class="form-control" type="text" id="validi" size="4" autocomplete="off" name="validity"
                value="" required="1"></td>
    </tr>
    <tr id="graceperiod" style="display:none;">
        <td class="align-middle">Masa Tenggang</td>
        <td><input class="form-control" type="text" id="gracepi" size="4" autocomplete="off"
                name="graceperiod" placeholder="5m" value="5m" required="1"></td>
    </tr>
    <tr>
        <td class="align-middle">Price Rp</td>
        <td><input class="form-control" type="text" size="10" min="0" name="price" value=""></td>
    </tr>
    <tr>
        <td class="align-middle">Selling Price Rp</td>
        <td><input class="form-control" type="text" size="10" min="0" name="sprice" value=""></td>
    </tr>
    <tr>
        <td>Lock User</td>
        <td>
            <select class="form-control" id="lockunlock" name="lockunlock" required="1">
                <option value="Disable">Disable</option>
                <option value="Enable">Enable</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="align-middle">Parent Queue</td>
        <td>
            <select class="form-control " name="parent">
                <option>none</option>
                <?php $TotalReg = count($getallqueue);
                for ($i = 0; $i < $TotalReg; $i++) {
                    echo '<option>' . $getallqueue[$i]['name'] . '</option>';
                }
                ?>
            </select>
        </td>
    </tr>
</table>

@push('js')
    <script>
        function remSpace() {
            var input = document.getElementsByName('name')[0];
            var value = input.value;
            var newValue = value.replace(/\s+/g, '-');
            input.value = newValue;
        }
    </script>

    <script>
        function RequiredV() {
            var e = document.getElementById("expmode").value,
                t = document.getElementById("validity").style,
                n = document.getElementById("validi");

            if ("rem" === e || "remc" === e) {
                t.display = "table-row";
                n.type = "text";
                if ("" === n.value) {
                    n.value = "";
                }
                $("#validi").focus();
            } else if ("ntf" === e || "ntfc" === e) {
                t.display = "table-row";
                n.type = "text";
                if ("" === n.value) {
                    n.value = "";
                }
                $("#validi").focus();
            } else {
                t.display = "none";
                n.type = "hidden";
            }
        }
    </script>
@endpush
