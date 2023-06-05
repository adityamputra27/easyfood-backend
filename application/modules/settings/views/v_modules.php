<table class="table table-bordered table-hovered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Menu</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($modules->result() as $key => $value): ?>
            <tr>
                <td class="text-bold"><?= $key + 1 ?></td>
                <td class="text-bold"><?= strtoupper($value->nama) ?>
                </td>
                <td>
                    <label class="switch">
                        <input type="checkbox" name="id_module[]" value="<?= $value->id ?>" <?= $value->id && isset($role_access) && in_array($value->id, $role_access) ? 'checked="checked"' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                </td>
                <?php if(count($value->children) > 0): ?>
                    <?php foreach($value->children as $key => $children): ?>
                        <tr >
                            <td>&nbsp;</td>
                            <td>- <?= strtoupper($children->nama) ?></td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" name="id_sub_module[]" value="<?= $children->id_sub_module ?>" <?= $children->id_sub_module && isset($role_access_details) && in_array($children->id_sub_module, $role_access_details) ? 'checked="checked"' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tr>
            
        <?php endforeach ?>
    </tbody>
</table>