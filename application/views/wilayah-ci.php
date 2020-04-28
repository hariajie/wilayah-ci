<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>
	 <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Dropdown Wilayah Indonesia</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.5.0.min.js" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<div class="container">
	<div class ="card border-primary">
		<div class="card-header bg-primary  text-white">Dropdown Wilayah Indonesia</div>
		<div class="card-body">
			<table class="table table-bordered">
				<tbody>
					 <tr>
                  <th>Provinsi</th>
                  <td>
                    <select class="form-control cmb_select2" id="province" name="province">
                      <option value="">Pilih Provinsi</option>
                      <?php
                      foreach ($province_list as $prov) {
                        $selected = $responden->province == $prov->code ? "selected": null;
                        ?>
                        <option value="<?php echo $prov->code ?>" <?php echo $selected ?>><?php echo $prov->name ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Kabupaten/Kota</th>
                  <td>
                    <select class="form-control cmb_select2" id="regency" name="regency">
                      <option value="">Pilih Kabupaten/Kota</option>
                      <?php
                      foreach ($regency_list as $reg) {
                        $selected = $responden->regency == $reg->code ? "selected": null;
                        ?>
                        <option value="<?php echo $reg->code ?>" <?php echo $selected ?>><?php echo $reg->name ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Kecamatan</th>
                  <td>
                    <select class="form-control cmb_select2" id="district" name="district">
                      <option value="">Pilih Kecamatan</option>
                      <?php
                      foreach ($district_list as $dis) {
                        $selected = $responden->district == $dis->code ? "selected": null;
                        ?>
                        <option value="<?php echo $dis->code ?>" <?php echo $selected ?>><?php echo $dis->name ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th>Kelurahan</th>
                  <td>
                    <select class="form-control cmb_select2" id="village" name="village">
                      <option value="">Pilih Kelurahan</option>
                      <?php
                      foreach ($village_list as $vil) {
                        $selected = $responden->village == $vil->code ? "selected": null;
                        ?>
                        <option value="<?php echo $vil->code ?>" <?php echo $selected ?>><?php echo $vil->name ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </td>
                </tr>
				</tbody>
			</table>
		</div>

	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/select2/css/select2.min.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css');?>">
<style>
.move-left {
    width: auto;
    box-shadow: none;
  }
</style>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/select2/js/select2.min.js') ?>"></script>
<script type="text/javascript">
  $(function(e) {
    $(".cmb_select2").select2({
      theme: 'bootstrap4',
      width: '100%'
    })
    $("#province").change(function() {
      set_loader_select2('regency');
      reset_select2('district', 'Pilih Kecamatan');
      reset_select2('village', 'Pilih Kelurahan');
      $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "<?php echo site_url('wilayah/regency/') ?>" + $(this).val(),
        success: function(data) {
          set_option_select2('regency', data, 'Pilih Kabupaten/Kota', 'code', 'name');
        },
        error: function(xhr, msg, e) {
          console.log(xhr.responseText);
        }
      });
    });
    $("#regency").change(function() {
      set_loader_select2('district');
      reset_select2('village', 'Pilih Kelurahan');
      $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "<?php echo site_url('wilayah/district/') ?>" + $(this).val(),
        success: function(data) {
          set_option_select2('district', data, 'Pilih Kecamatan', 'code', 'name');
        },
        error: function(xhr, msg, e) {
          console.log(xhr.responseText);
        }
      });
    });
    $("#district").change(function() {
      set_loader_select2('village');
      $.ajax({
        type: "GET",
        dataType: "JSON",
        url: "<?php echo site_url('wilayah/village/') ?>" + $(this).val(),
        success: function(data) {
          set_option_select2('village', data, 'Pilih Kelurahan', 'code', 'name');
        },
        error: function(xhr, msg, e) {
          console.log(xhr.responseText);
        }
      });
    });
  })
  function set_option_select2(cmb_name, data, placeholder, key_name, value_name) {
      if ( key_name == '' )
          key_name = 'id';
      if ( value_name == '' )
          value_name = 'name';

      var result_html = '<option value="">'+placeholder+'</option>';
      var selected_text = '';
      for ( var i=0; i < data.length; i++ ) {
          result_html += '<option ';
          result_html += 'value="'+ data[i][key_name] +'">';
          result_html += data[i][value_name];
          result_html += '</option>';
      }
      $('#'+cmb_name).html(result_html);
      $('#select2-'+cmb_name+'-container').html('');
      $('#select2-'+cmb_name+'-container').append(placeholder);
  }

  function set_loader_select2(cmb_name) {
      $('#'+cmb_name).val('');
      $('#select2-'+cmb_name+'-container').html('Loading ...');
      $('#select2-'+cmb_name+'-container .select2-selection__placeholder').html('Loading ...');
  }
  function reset_select2(cmb_name, placeholders) {
      $('#'+cmb_name).html('<option value="">'+placeholders+'</option>');
      $('#'+cmb_name).parent().children('.select2-selection__rendered').attr('title', '');
      $('#select2-'+cmb_name+'-container').html(placeholders);
      $('#select2-'+cmb_name+'-container').attr('title', placeholders);
  }
  function reset_selected_select2(cmb_name, placeholders, selected_value) {
      $('#'+cmb_name).val(selected_value);
      $('#select2-'+cmb_name+'-container').html($("#"+cmb_name+" option[value='"+selected_value+"']").text());
      $('#select2-'+cmb_name+'-container .select2-selection__placeholder').html($("#"+cmb_name+" option[value='"+selected_value+"']").text());
  }
</script>
</body>
</html>