<div class="wrap">
    <h1>Trainer Availability List</h1>

    <div style="margin-bottom:15px;">
        <a href="<?php echo admin_url('admin.php?page=tam_availability'); ?>" class="button button-primary">
            + Add Availability
        </a>
    </div>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th width="50">#</th>
                <th>Trainer</th>
                <th>Day</th>
                <th>From</th>
                <th>To</th>
                <th width="100">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($results)) : 
                $i = 1;
                foreach ($results as $row) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo esc_html($row->trainer_name ?: '—'); ?></td>
                        <td><?php echo ucfirst(esc_html($row->day_of_week)); ?></td>
                        <td><?php echo esc_html($row->from_time); ?></td>
                        <td><?php echo esc_html($row->to_time); ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=tam_availability&edit=' . $row->id); ?>" class="button button-small">Edit</a>
                            <a href="<?php echo admin_url('admin.php?page=tam_availability_list&delete=' . $row->id); ?>" 
                               onclick="return confirm('Delete this availability?')" 
                               class="button button-small" style="color:#d63638;">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6">No availability records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
