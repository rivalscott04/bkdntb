<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<script>
(function($) {
    var ENDPOINT = <?php echo json_encode(site_url('admin/berita/cari')); ?>;
    var DEBOUNCE_MS = 400;
    var currentRequest = null;
    var debounceTimer = null;
    var datePicker = null;

    var $form = $('#admin-berita-filter');
    var $tbody = $('#admin-berita-tbody');
    var $pagination = $('#admin-berita-pagination');
    var $meta = $('#admin-berita-meta');
    var $panel = $('#admin-berita-panel');
    var $loading = $('#admin-berita-loading');
    var $rangeInput = $('#filter-tanggal-range');

    function formatDate(dt) {
        if (!dt || typeof dt.format !== 'function') {
            return '';
        }
        return dt.format('YYYY-MM-DD');
    }

    function getDateRangeFilters() {
        var dari = '';
        var sampai = '';
        if (datePicker) {
            var start = datePicker.getStartDate();
            var end = datePicker.getEndDate();
            if (start) {
                dari = formatDate(start);
            }
            if (end) {
                sampai = formatDate(end);
            } else if (start) {
                sampai = dari;
            }
        }
        return {
            tanggal_dari: dari,
            tanggal_sampai: sampai
        };
    }

    function getFilters(page) {
        var range = getDateRangeFilters();
        return {
            q: $.trim($('#filter-q').val()),
            bidang: $('#filter-bidang').val(),
            status: $('#filter-status').val(),
            tanggal_dari: range.tanggal_dari,
            tanggal_sampai: range.tanggal_sampai,
            page: page || 1
        };
    }

    function setLoading(isLoading) {
        $panel.toggleClass('is-loading', isLoading);
        $loading.prop('hidden', !isLoading);
    }

    function updateMeta(total, shown) {
        $meta.text('Menampilkan ' + shown + ' dari ' + total + ' berita');
    }

    function updateUrl(params) {
        if (!window.history || !window.history.replaceState) {
            return;
        }
        var query = $.param(params);
        var url = window.location.pathname + (query ? '?' + query : '');
        window.history.replaceState(null, '', url);
    }

    function fetchList(page) {
        var params = getFilters(page);

        if (currentRequest) {
            currentRequest.abort();
        }

        setLoading(true);

        currentRequest = $.ajax({
            url: ENDPOINT,
            method: 'GET',
            data: params,
            dataType: 'json'
        }).done(function(res) {
            if (!res) {
                return;
            }
            $tbody.html(res.html || '');
            $pagination.html(res.pagination || '');
            updateMeta(res.total || 0, res.shown != null ? res.shown : $tbody.find('tr').length);
            updateUrl(params);
        }).fail(function(xhr, status) {
            if (status === 'abort') {
                return;
            }
            $tbody.html('<tr><td colspan="6" class="text-center admin-muted" style="padding:40px;">Gagal memuat data. Coba lagi.</td></tr>');
            $pagination.empty();
        }).always(function() {
            setLoading(false);
            currentRequest = null;
        });
    }

    function scheduleFetch(page) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function() {
            fetchList(page || 1);
        }, DEBOUNCE_MS);
    }

    function initDateRangePicker() {
        if (!$rangeInput.length || typeof Litepicker === 'undefined') {
            return;
        }

        var start = $rangeInput.data('start') || null;
        var end = $rangeInput.data('end') || null;
        var options = {
            element: $rangeInput[0],
            singleMode: false,
            format: 'YYYY-MM-DD',
            numberOfMonths: 2,
            numberOfColumns: 2,
            autoApply: true,
            tooltipText: {
                one: 'hari',
                other: 'hari'
            },
            buttonText: {
                previousMonth: '<',
                nextMonth: '>',
                reset: 'Hapus',
                apply: 'Terapkan'
            },
            setup: function(picker) {
                picker.on('selected', function(date1, date2) {
                    if (date1 && date2) {
                        fetchList(1);
                    }
                });
                picker.on('clear:selection', function() {
                    fetchList(1);
                });
            }
        };

        if (start) {
            options.startDate = start;
        }
        if (end) {
            options.endDate = end;
        }

        datePicker = new Litepicker(options);
    }

    $form.on('input', '#filter-q', function() {
        scheduleFetch(1);
    });

    $form.on('change', '#filter-bidang, #filter-status', function() {
        fetchList(1);
    });

    $('#filter-reset').on('click', function() {
        $('#filter-q').val('');
        $('#filter-bidang').val('');
        $('#filter-status').val('');
        if (datePicker) {
            datePicker.clearSelection();
        }
        fetchList(1);
    });

    $pagination.on('click', 'a.page-link', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        if (!href) {
            return;
        }
        var match = href.match(/[?&]page=(\d+)/);
        var page = match ? parseInt(match[1], 10) : 1;
        fetchList(page);
        $('html, body').animate({ scrollTop: $panel.offset().top - 20 }, 200);
    });

    initDateRangePicker();
})(jQuery);
</script>
