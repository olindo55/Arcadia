<?php 
use App\Database\DbUtils;

$query = DbUtils::getPdo()->query('SELECT * FROM opening');
$days = $query->fetchAll(\PDO::FETCH_ASSOC);
?>

    <div class="container-fluid col-md-5 adm d-flex flex-column">
        <h1>Horaires d'ouverture</h1>
        <table id="list-opening"  class="table table-hover table-responsive">
            <thead>
                <tr class="table-primary ">
                    <th> Jours </th>
                    <th> Horaires d'ouverture </th>
                    <th> Horaires de fermeture </th>
                    <th> Ouvert/fermé</th>
                </tr>
            </thead>
            <tbody >
                <?php
                foreach ($days as $day) {
                    echo '<tr data-id="' . $day['id'] . '">';
                    echo '<td>' . $day['day'] . '</td>';
                    $disabled = $day['closure'] ? 'disabled' : '';
                    // opening
                    echo '<td>';
                        // hours
                        echo '<select class="form-select w-auto d-inline-block" name="opening_hour"' . $disabled . ' >';
                        for ($i = 1; $i <= 23; $i++) {
                            $selected = ($i == $day['opening_hour']) ? 'selected' : '';
                            echo '<option value="' . $i . '" ' . $selected . '>' . sprintf('%02d', $i) . '</option>';
                        }
                        echo '</select><span class="mx-2">:</span>';
                        // minutes
                        echo '<select class="form-select w-auto d-inline-block" name="opening_minute"' . $disabled . ' >';
                        for ($i = 0; $i <= 45; $i += 15) {
                            $selected = ($i == $day['opening_minute']) ? 'selected' : '';
                            echo '<option value="' . $i . '" ' . $selected . '>' . sprintf('%02d', $i) . '</option>';
                        }
                        echo '</select>';
                    echo '</td>';
                    // echo ' <td> test </td>' ;

                    // closing
                    echo '<td>';
                        // hours
                        echo '<select class="form-select w-auto d-inline-block" name="closing_hour"' . $disabled . ' >';
                        for ($i = 1; $i <= 23; $i++) {
                            $selected = ($i == $day['closing_hour']) ? 'selected' : '';
                            echo '<option value="' . $i . '" ' . $selected . '>' . sprintf('%02d', $i) . '</option>';
                        }
                        echo '</select><span class="mx-2">:</span>';
                        // minutes
                        echo '<select class="form-select w-auto d-inline-block" name="closing_minute"' . $disabled . ' >';
                        for ($i = 0; $i <= 45; $i += 15) {
                            $selected = ($i == $day['closing_minute']) ? 'selected' : '';
                            echo '<option value="' . $i . '" ' . $selected . '>' . sprintf('%02d', $i) . '</option>';
                        }
                        echo '</select>';
                    echo '</td>';

                    echo '<td>'; 
                    ?>
                        <input class="form-check-input" type="radio" name="opening<?php echo $day['day']?>" id="open" <?php echo $day['closure'] ? '' : 'checked'?>>
                        <label class="form-check-label" for="open">
                            Ouvert
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="opening<?php echo $day['day']?>" id="closed" <?php echo $day['closure'] ? 'checked' : ''?>>
                        <label class="form-check-label" for="closed">
                            Fermé
                        </label>
                    <?php
                    echo '</td>';

                    // echo '<td>';
                    // echo '<select class="form-select" name="role">';
                    // foreach ($roles as $role) {
                    //     $selected = ($role['role'] == $user['role']) ? 'selected' : '';
                    //     echo '<option value="' . $role['id'] . '" ' . $selected . '>' . $role['role'] . '</option>';
                    // }
                    // echo '</select>';
                    // echo '</td>';

                    // echo '<td class="icon-cell">' .
                    //     '<i class="bi bi-trash" data-id="' . $user['id'] . '"></i>'.
                    //     '</td>';
                    // echo '</tr>';
                }
                ?>
            </tbody>
        </table> 
        <button type="button" id="openingButton" class="btn btn-primary align-self-center mb-4 col-4">Mettre à jour</button>
    </div>
        
        

