<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>REST Server HRIS</title>

    <style>

    ::selection { background-color: #E13300; color: white; }
    ::-moz-selection { background-color: #E13300; color: white; }

    body {
        background-color: #FFF;
        margin: 40px;
        font: 16px/20px normal Helvetica, Arial, sans-serif;
        color: #4F5155;
        word-wrap: break-word;
    }

    a {
        color: #039;
        background-color: transparent;
        font-weight: normal;
    }

    h1 {
        color: #444;
        background-color: transparent;
        border-bottom: 1px solid #D0D0D0;
        font-size: 24px;
        font-weight: normal;
        margin: 0 0 14px 0;
        padding: 14px 15px 10px 15px;
    }

    code {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        font-size: 16px;
        background-color: #f9f9f9;
        border: 1px solid #D0D0D0;
        color: #002166;
        display: block;
        margin: 14px 0 14px 0;
        padding: 12px 10px 12px 10px;
    }

    #body {
        margin: 0 15px 0 15px;
    }

    p.footer {
        text-align: right;
        font-size: 16px;
        border-top: 1px solid #D0D0D0;
        line-height: 32px;
        padding: 0 10px 0 10px;
        margin: 20px 0 0 0;
    }

    #container {
        margin: 10px;
        border: 1px solid #D0D0D0;
        box-shadow: 0 0 8px #D0D0D0;
    }
    </style>
</head>
<body>

<div id="container">
    <h1>REST Server HRIS</h1>

    <div id="body">

        <h2><a href="<?php echo site_url(); ?>">Master Data</a></h2>

        <p>
            Click on the links to check whether the REST server is working.
        </p>

        <ol>
            <li><a href="<?php echo site_url('master/jabatan/index'); ?>">Data Jabatan</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('master/karyawan/index'); ?>">Data Karyawan</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('master/jam_kerja/index'); ?>">Data Jam Kerja</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('master/team/index'); ?>">Data Team</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('master/seragam/index'); ?>">Data Seragam</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('master/departement/index'); ?>">Data Departement</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('master/lokasi/index'); ?>">Data Lokasi</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('master/Perusahaan/index'); ?>">Data Perusahaan</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('master/event/index'); ?>">Data Event</a> - defaulting to JSON</li> &nbsp;
        </ol>

    </div>

    <div id="body">

        <h2><a href="<?php echo site_url(); ?>">Master Pengajuan</a></h2>

        <p>
            Click on the links to check whether the REST server is working.
        </p>

        <ol>
            <li><a href="<?php echo site_url('pengajuan/izin_full_day/index'); ?>">Izin Full Day</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/izin_non_full_day/index'); ?>">Izin Non Full Day</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/dinas_full_day/index'); ?>">Dinas Full Day</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/dinas_non_full_day/index'); ?>">Dinas Non Full Day</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/cuti_tahunan/index'); ?>">Cuti Tahunan</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/cuti_khusus/index'); ?>">Cuti Khusus</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/absen_manual/index'); ?>">Absen Manual</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/shifting/index'); ?>">Shifting</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/SK/index'); ?>">Surat Keterangan</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/Mutasi_rotasi/index'); ?>">Mutasi dan Rotasi</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/Karyawan_Project/index'); ?>">Karyawan Project</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/Pengajuan_seragam/index'); ?>">Pengajuan Seragam Karyawan</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/surat_kontrak/index'); ?>">Surat Kontrak</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/punishment/index'); ?>">Surat Peringatan</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/Absenmobile/index'); ?>">Absen Mobile</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/Pengembalian_seragam/index'); ?>">Pengembalian Seragam</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('pengajuan/Logactivity/index_getketerangan'); ?>">Log Activity</a> - defaulting to JSON</li> &nbsp;
        </ol>

    </div>

    <div id="body">

        <h2><a href="<?php echo site_url(); ?>">Permintaan</a></h2>

        <p>
            Click on the links to check whether the REST server is working.
        </p>

        <ol>
            <li><a href="<?php echo site_url('api/login/index'); ?>">Login</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('api/kontrak/index'); ?>">Karyawan Kontrak</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('api/resign/index'); ?>">Karyawan Resign</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('api/absensi/index'); ?>">Rekap Absensi</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('api/gallup/index'); ?>">Rekap Gallup Assessment</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('api/gallup/index_survey'); ?>">Rekap Survey</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('api/gallup/index_survey_saran'); ?>">Rekap Survey Saran</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('api/cuti/index'); ?>">Rekap Hak Cuti</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('api/nomor_pengajuan/index_full_day'); ?>">Nomor Pengajuan Izin</a> - defaulting to JSON</li>
        </ol>

    </div>

    <div id="body">

        <h2><a href="<?php echo site_url(); ?>">Interview Data</a></h2>

        <p>
            Click on the links to check whether the REST server is working.
        </p>

        <ol>
            <li><a href="<?php echo site_url('website/jadwal/index'); ?>">Jadwal Interview</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('website/detail/index'); ?>">Data Detail</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('website/pendidikan/index'); ?>">Data Pendidikan</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('website/rekomendasi/index'); ?>">Data Rekomendasi</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('website/hasil/index'); ?>">Data Hasil Interview</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('website/ojt/index'); ?>">Data Materi OJT</a> - defaulting to JSON</li> &nbsp;
            <li><a href="<?php echo site_url('website/materi/index'); ?>">OJT</a> - defaulting to JSON</li> &nbsp;
        </ol>
       

    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>'.CI_VERSION.'</strong>' : '' ?></p>
</div>

<script src="https://code.jquery.com/jquery-1.12.0.js"></script>

<script>
    // Create an 'App' namespace
    var App = App || {};

    // Basic rest module using an IIFE as a way of enclosing private variables
    App.rest = (function restModule(window) {
        // Fields
        var _alert = window.alert;
        var _JSON = window.JSON;

        // Cache the jQuery selector
        var _$ajax = null;

        // Cache the jQuery object
        var $ = null;

        // Methods (private)

        /**
         * Called on Ajax done
         *
         * @return {undefined}
         */
        function _ajaxDone(data) {
            // The 'data' parameter is an array of objects that can be iterated over
            _alert(_JSON.stringify(data, null, 2));
        }

        /**
         * Called on Ajax fail
         *
         * @return {undefined}
         */
        function _ajaxFail() {
            _alert('Oh no! A problem with the Ajax request!');
        }

        /**
         * On Ajax request
         *
         * @param {jQuery} $element Current element selected
         * @return {undefined}
         */
        function _ajaxEvent($element) {
            $.ajax({
                    // URL from the link that was 'clicked' on
                    url: $element.attr('href')
                })
                .done(_ajaxDone)
                .fail(_ajaxFail);
        }

        /**
         * Bind events
         *
         * @return {undefined}
         */
        function _bindEvents() {
            // Namespace the 'click' event
            _$ajax.on('click.app.rest.module', function (event) {
                event.preventDefault();

                // Pass this to the Ajax event function
                _ajaxEvent($(this));
            });
        }

        /**
         * Cache the DOM node(s)
         *
         * @return {undefined}
         */
        function _cacheDom() {
            _$ajax = $('#ajax');
        }

        // Public API
        return {
            /**
             * Initialise the following module
             *
             * @param {object} jQuery Reference to jQuery
             * @return {undefined}
             */
            init: function init(jQuery) {
                $ = jQuery;

                // Cache the DOM and bind event(s)
                _cacheDom();
                _bindEvents();
            }
        };
    }(window));

    // DOM ready event
    $(function domReady($) {
        // Initialise the App module
        App.rest.init($);
    });
</script>

</body>
</html>
