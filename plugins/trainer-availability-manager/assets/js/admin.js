jQuery(document).ready(function ($) {
    let dayIndex = 0;

    $('#add-day').on('click', function () {
        const dayHtml = `
        <div class="day-block" data-day-index="${dayIndex}">
            <h3>
                <input type="text" name="availability[${dayIndex}][day]" placeholder="Enter Day (e.g. Monday)" required />
                <button type="button" class="button-link delete-day" style="color:#d63638;">Remove</button>
            </h3>
            <div class="slots-container"></div>
            <p>
                <button type="button" class="button add-slot">+ Add Slot</button>
            </p>
            <hr/>
        </div>
        `;
        $('#days-container').append(dayHtml);
        dayIndex++;
    });

    // Add new slot to a specific day
    $(document).on('click', '.add-slot', function () {
        const dayBlock = $(this).closest('.day-block');
        const dayIdx = dayBlock.data('day-index');
        const slotCount = dayBlock.find('.slot').length;

        const slotHtml = `
        <div class="slot" style="margin-bottom:5px;">
            <input type="time" name="availability[${dayIdx}][slots][${slotCount}][from]" required /> 
            <span>to</span> 
            <input type="time" name="availability[${dayIdx}][slots][${slotCount}][to]" required />
            <button type="button" class="button-link delete-slot" style="color:#d63638;">Remove</button>
        </div>
        `;

        dayBlock.find('.slots-container').append(slotHtml);
    });

    // Remove a day
    $(document).on('click', '.delete-day', function () {
        $(this).closest('.day-block').remove();
    });

    // Remove a slot
    $(document).on('click', '.delete-slot', function () {
        $(this).closest('.slot').remove();
    });
});
