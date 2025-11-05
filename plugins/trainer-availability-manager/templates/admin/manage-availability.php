<div class="wrap">
    <h1>Trainer Availability</h1>

    <form method="post" id="tam-availability-form">
        <input type="hidden" name="tam_action" value="save_availability">

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
        </table>

        <h2>Days & Time Slots</h2>

        <div id="days-container"></div>

        <p>
            <button type="button" class="button button-secondary" id="add-day">+ Add Day</button>
        </p>

        <p>
            <button type="submit" class="button button-primary">Save </button>
        </p>
    </form>
</div>
