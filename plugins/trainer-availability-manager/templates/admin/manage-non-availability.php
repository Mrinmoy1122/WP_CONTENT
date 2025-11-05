<div class="wrap">
    <h1>Trainer Non-Availability</h1>

    <form method="post">
        <table class="form-table">
            <tr>
                <th>Select Trainer</th>
                <td>
                    <select name="trainer_id" required>
                        <option value="">-- Select Trainer --</option>
                        <?php foreach ($trainers as $trainer): ?>
                            <option value="<?php echo esc_attr($trainer->id); ?>"><?php echo esc_html($trainer->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th>Select Date</th>
                <td><input type="date" name="date" required></td>
            </tr>

            <tr>
                <th>Type</th>
                <td>
                    <label><input type="radio" name="type" value="full" checked> Full Day</label>
                    <label><input type="radio" name="type" value="partial"> Partial Day</label>
                </td>
            </tr>

            <tr class="partial-time" style="display:none;">
                <th>Unavailable Slots</th>
                <td>
                    <div class="slot-list">
                    </div>
                </td>
            </tr>
        </table>

        <p><button class="button-primary">Save</button></p>
    </form>
</div>
