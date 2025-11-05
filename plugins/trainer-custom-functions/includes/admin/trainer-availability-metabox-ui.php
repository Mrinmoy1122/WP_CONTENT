<?php
if (!defined('ABSPATH')) exit; 

function render_trainer_availability_metabox($post) {
    wp_nonce_field('save_trainer_availability', 'trainer_availability_nonce');

    $trainers = get_posts([
        'post_type' => 'trainer',
        'numberposts' => -1
    ]);
    $availability = get_post_meta($post->ID, 'trainer_availability', true) ?: [];

    ?>


    <div id="availability-days">
        <?php if (!empty($availability)): ?>
            <?php foreach ($availability as $dayIndex => $dayData): ?>
                <div class="availability-day">
                    <label>Day:</label>
                    <select name="availability[<?php echo $dayIndex; ?>][day]">
                        <?php foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day): ?>
                            <option value="<?php echo esc_attr($day); ?>" <?php selected($dayData['day'], $day); ?>>
                                <?php echo esc_html($day); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="remove-day">Remove Day</button>

                    <div class="slots">
                        <?php foreach ($dayData['slots'] as $slotIndex => $slot): ?>
                            <div class="slot">
                                <label>From:</label>
                                <input type="time" name="availability[<?php echo $dayIndex; ?>][slots][<?php echo $slotIndex; ?>][from]" value="<?php echo esc_attr($slot['from']); ?>" />
                                <label>To:</label>
                                <input type="time" name="availability[<?php echo $dayIndex; ?>][slots][<?php echo $slotIndex; ?>][to]" value="<?php echo esc_attr($slot['to']); ?>" />
                                <button type="button" class="remove-slot">Remove Slot</button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" class="add-slot">+ Add Slot</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <button type="button" id="add-day">+ Add Day</button>

    <script>
    jQuery(document).ready(function($) {
        let dayIndex = <?php echo !empty($availability) ? count($availability) : 0; ?>;

        $('#add-day').on('click', function() {
            const html = `
                <div class="availability-day">
                    <label>Day:</label>
                    <select name="availability[\${dayIndex}][day]">
                        <option value="">Select Day</option>
                        ${['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'].map(day => `<option value="${day}">${day}</option>`).join('')}
                    </select>
                    <button type="button" class="remove-day">Remove Day</button>
                    <div class="slots">
                        <div class="slot">
                            <label>From:</label>
                            <input type="time" name="availability[\${dayIndex}][slots][0][from]" />
                            <label>To:</label>
                            <input type="time" name="availability[\${dayIndex}][slots][0][to]" />
                            <button type="button" class="remove-slot">Remove Slot</button>
                        </div>
                    </div>
                    <button type="button" class="add-slot">+ Add Slot</button>
                </div>`;
            $('#availability-days').append(html);
            dayIndex++;
        });

        $(document).on('click', '.add-slot', function() {
            const slotsDiv = $(this).siblings('.slots');
            const dayIndex = slotsDiv.closest('.availability-day').index();
            const slotIndex = slotsDiv.children('.slot').length;
            const slotHtml = `
                <div class="slot">
                    <label>From:</label>
                    <input type="time" name="availability[\${dayIndex}][slots][\${slotIndex}][from]" />
                    <label>To:</label>
                    <input type="time" name="availability[\${dayIndex}][slots][\${slotIndex}][to]" />
                    <button type="button" class="remove-slot">Remove Slot</button>
                </div>`;
            slotsDiv.append(slotHtml);
        });

        $(document).on('click', '.remove-day', function() {
            $(this).closest('.availability-day').remove();
        });
        $(document).on('click', '.remove-slot', function() {
            $(this).closest('.slot').remove();
        });
    });
    </script>
    <?php
}
