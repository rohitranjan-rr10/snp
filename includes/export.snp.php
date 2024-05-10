<?php
    include_once 'config.snp.php';

    $sql = "SELECT * FROM master_data";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="master_data_export.csv"');

        $output = fopen('php://output', 'w');

        $fields = mysqli_fetch_fields($result);
        $headers = [];

        foreach ($fields as $field) {
            $headers[] = $field->name;
        }

        fputcsv($output, $headers);

        while ($row = mysqli_fetch_assoc($result)) {
            $json_columns = ['description', 'nature_of_asset', 'quantity', 'gross_amount', 'no_of_item_found_ok', 'shortage', 'excess', 'reported_curr_loc'];
            $max_count = 1;

            foreach ($json_columns as $column) {
                if (array_key_exists($column, $row) && is_json($row[$column])) {
                    $json_data = json_decode($row[$column]);
                    $max_count = max($max_count, count($json_data));
                }
            }

            for ($i = 0; $i < $max_count; $i++) {
                $new_row = $row;

                foreach ($json_columns as $column) {
                    if (array_key_exists($column, $row) && is_json($row[$column])) {
                        $json_data = json_decode($row[$column]);
                        $new_row[$column] = isset($json_data[$i]) ? $json_data[$i] : '';
                    }
                }

                fputcsv($output, $new_row);
            }
        }

        fclose($output);
        exit();
    } else {
        header("Location: ../admin/export.php?error=csverror");
    }

    mysqli_close($conn);

    function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
?>
