@extends('layouts.app')

@section('title', 'E-sklep Administracja')

@section('content')
    {{--    <h2>Zamówienia:</h2>--}}
    {{--    <a href="{{ route('limit') }}" class="btn btn-success">Ostatnie 10</a>--}}
    <div class="opisFiltr">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-7 border-end">Zamówienia</div>
                    <div class="col-5">
                        <div class="pb-1 border-bottom text-center">
                            Filtr
                        </div>
                        <div class="row">
                            <div class="col col-5">
                                <div class="form-check">
                                    <input class="form-check-input filtrStatus" type="checkbox" value=""
                                           id="filtrStatus">
                                    <label class="form-check-label ms-1" for="filtrStatus">
                                        Status
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input filtrItem" type="checkbox" value="nowe" id="nowe"
                                               disabled>
                                        <label class="form-check-label ms-1" for="nowe">
                                            nowe
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input filtrItem" type="checkbox" value="w realizacji"
                                               id="W_realizacji" disabled>
                                        <label class="form-check-label ms-1" for="W_realizacji">
                                            w realizacji
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input filtrItem" type="checkbox" value="zrealizowane"
                                               id="zrealizowane" disabled>
                                        <label class="form-check-label ms-1" for="zrealizowane">
                                            zrealizowane
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-7">
                                <div class="form-check">
                                    <input type="checkbox" id="date" class="form-check-input checkFilter" name="date">
                                    <label class="form-check-label ms-1" for="date">Zakres dat</label>
                                </div>
                                <div id="daterange" class="float-end"
                                     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; text-align:center">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span>
                                    <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end pt-1">
                    <button id="filter" class="btn btn-outline-success btn-sm filter">Filtruj</button>
                    <button id="filterOff" class="btn btn-outline-primary btn-sm ms-2 filterOff">Wyłącz filtr</button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered stripe" id="daterange_table">
                    <thead>
                    <tr>
                        <th>Numer</th>
                        <th>Nazwa</th>
                        <th>Adres</th>
                        <th></th>
                        <th></th>
                        <th>E-mail</th>
                        <th>Status</th>
                        <th>Suma</th>
                        <th>Data</th>
                        <th>Szczegóły</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var checkBoxDate = document.getElementById('date');
            var checkBoxStatus = document.getElementById('filtrStatus');
            var checkBoxNowe = document.getElementById('nowe');
            var checkBoxWrealizacji = document.getElementById('W_realizacji');
            var checkBoxZrealizowane = document.getElementById('zrealizowane');
            var start_date = moment().subtract(1, 'M');
            var end_date = moment();
            //var end_date = moment().add(1, 'd');
            // var start_date = moment().startOf('month');
            // var end_date = moment().endOf('month');

            $('#daterange span').html(start_date.format('DD.MM.YYYY') + ' - ' + end_date.format('DD.MM.YYYY'));

            $('#daterange').daterangepicker({
                locale: {
                    "format": "DD.MM.YYYY",
                    "separator": " - ",
                    "applyLabel": "Zatwierdź",
                    "cancelLabel": "Anuluj",
                    "fromLabel": "Od",
                    "toLabel": "Do",
                    "customRangeLabel": "Własny",
                    "daysOfWeek": [
                        "Ni",
                        "Po",
                        "Wt",
                        "Śr",
                        "Cz",
                        "Pi",
                        "So"
                    ],
                    "monthNames": [
                        "Styczeń",
                        "Luty",
                        "Marzec",
                        "Kwiecień",
                        "Maj",
                        "Czerwiec",
                        "Lipiec",
                        "Sierpień",
                        "Wrzesień",
                        "Październik",
                        "Listopad",
                        "Grudzień"
                    ],
                    "firstDay": 1
                },
                startDate: start_date,
                endDate: end_date
            }, function (start_date, end_date) {
                $('#daterange span').html(start_date.format('DD.MM.YYYY') + ' - ' + end_date.format('DD.MM.YYYY'));
                //table.draw();
            });

            var table = $('#daterange_table').DataTable({
                language: {
                    "processing": "Przetwarzanie...",
                    "search": "Szukaj:",
                    "lengthMenu": "Pokaż _MENU_ pozycji",
                    "info": "Pozycje od _START_ do _END_ z _TOTAL_ łącznie",
                    "infoEmpty": "Pozycji 0 z 0 dostępnych",
                    "infoFiltered": "(filtrowanie spośród _MAX_ dostępnych pozycji)",
                    "loadingRecords": "Wczytywanie...",
                    "zeroRecords": "Nie znaleziono pasujących pozycji",
                    "paginate": {
                        "first": "<<",
                        "previous": "<",
                        "next": ">",
                        "last": ">>"
                    },
                    "aria": {
                        "sortAscending": ": aktywuj, by posortować kolumnę rosnąco",
                        "sortDescending": ": aktywuj, by posortować kolumnę malejąco"
                    },
                    "autoFill": {
                        "cancel": "Anuluj",
                        "fill": "Wypełnij wszystkie komórki <i>%d<\/i>",
                        "fillHorizontal": "Wypełnij komórki w poziomie",
                        "fillVertical": "Wypełnij komórki w pionie"
                    },
                    "buttons": {
                        "collection": "Zbiór <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                        "colvis": "Widoczność kolumny",
                        "colvisRestore": "Przywróć widoczność",
                        "copy": "Kopiuj",
                        "copyKeys": "Naciśnij Ctrl lub u2318 + C, aby skopiować dane tabeli do schowka systemowego. <br \/> <br \/> Aby anulować, kliknij tę wiadomość lub naciśnij Esc.",
                        "copySuccess": {
                            "1": "Skopiowano 1 wiersz do schowka",
                            "_": "Skopiowano %d wierszy do schowka"
                        },
                        "copyTitle": "Skopiuj do schowka",
                        "csv": "CSV",
                        "excel": "Excel",
                        "pageLength": {
                            "-1": "Pokaż wszystkie wiersze",
                            "_": "Pokaż %d wierszy"
                        },
                        "pdf": "PDF",
                        "print": "Drukuj",
                        "createState": "Utwórz stan",
                        "removeAllStates": "Usuń wszystkie stany",
                        "removeState": "Usuń",
                        "renameState": "Zmień nazwę",
                        "savedStates": "Zapisane stany",
                        "stateRestore": "Stan %d",
                        "updateState": "Aktualizuj"
                    },
                    "emptyTable": "Brak danych w tabeli",
                    "searchBuilder": {
                        "add": "Dodaj warunek",
                        "clearAll": "Wyczyść wszystko",
                        "condition": "Warunek",
                        "data": "Dane",
                        "button": {
                            "_": "Aktywne zapytania",
                            "0": "Budowanie zapytania"
                        },
                        "conditions": {
                            "array": {
                                "contains": "Zawiera",
                                "empty": "Pusta",
                                "equals": "Równa się",
                                "not": "Nie",
                                "notEmpty": "Nie pusta",
                                "without": "Bez"
                            },
                            "date": {
                                "after": "Po",
                                "before": "Przed",
                                "between": "Pomiędzy",
                                "empty": "Pusto",
                                "equals": "Równa",
                                "not": "Nie",
                                "notBetween": "Nie pomiędzy",
                                "notEmpty": "Nie pusta"
                            },
                            "number": {
                                "between": "Pomiędzy",
                                "empty": "Pusty",
                                "equals": "Równy",
                                "gt": "Większy niż",
                                "gte": "Równy lub większy niż",
                                "lt": "Mniejszy niż",
                                "lte": "Równy lub mniejszy niż",
                                "not": "Nie",
                                "notBetween": "Nie pomiędzy",
                                "notEmpty": "Nie pusty"
                            },
                            "string": {
                                "contains": "Zawiera",
                                "empty": "Pusty",
                                "endsWith": "Kończy się na",
                                "equals": "Równa się",
                                "not": "Nie",
                                "notEmpty": "Nie pusty",
                                "startsWith": "Zaczyna się od",
                                "notContains": "Nie zawiera",
                                "notStartsWith": "Nie zaczyna się od",
                                "notEndsWith": "Nie kończy się na"
                            }
                        },
                        "deleteTitle": "Czyszczenie",
                        "leftTitle": "Lewy",
                        "logicAnd": "I",
                        "logicOr": "Lub",
                        "rightTitle": "Prawy",
                        "title": {
                            "_": "Aktywne zapytania",
                            "0": "Budowanie zapytania"
                        },
                        "value": "Wartość"
                    },
                    "datetime": {
                        "amPm": [
                            "am",
                            "pm"
                        ],
                        "hours": "Godzina",
                        "minutes": "Minuta",
                        "next": "Następne",
                        "previous": "Poprzednie",
                        "seconds": "Sekunda",
                        "unknown": "nieznana",
                        "months": {
                            "0": "Styczeń",
                            "1": "Luty",
                            "10": "Listopad",
                            "11": "Grudzień",
                            "2": "Marzec",
                            "3": "Kwiecień",
                            "4": "Maj",
                            "5": "Czerwiec",
                            "6": "Lipiec",
                            "7": "Sierpień",
                            "8": "Wrzesień",
                            "9": "Październik"
                        },
                        "weekdays": [
                            "Nd",
                            "Pn",
                            "Wt",
                            "Śr",
                            "Czw",
                            "Pt",
                            "So"
                        ]
                    },
                    "editor": {
                        "close": "Zamknij",
                        "create": {
                            "button": "Dodaj",
                            "submit": "Dodaj",
                            "title": "Dodawanie nowego wpisu"
                        },
                        "edit": {
                            "button": "Edytuj",
                            "submit": "Aktualizuj",
                            "title": "Aktualizacja wpisu"
                        },
                        "error": {
                            "system": "Nastąpił błąd systemu (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Więcej informacji&lt;\\\/a&gt;).<\/a>"
                        },
                        "multi": {
                            "info": "Wybrane pole zawiera wiele elementów z różnymi wartościami. Aby zmienić ich wartość kliknij w nie, inaczej zachowane zostaną ich wartości domyślne.",
                            "noMulti": "Ta wartość może być edytowana oddzielnie - niezależnie od grupy.",
                            "restore": "Cofnij zmiany",
                            "title": "Pole z wieloma wartościami"
                        },
                        "remove": {
                            "button": "Usuń",
                            "confirm": {
                                "_": "Czy na pewno chcesz usunąć %d rzędów?",
                                "1": "Czy na pewno chcesz usunąć 1 rząd?"
                            },
                            "submit": "Usuń",
                            "title": "Usuwanie"
                        }
                    },
                    "searchPanes": {
                        "clearMessage": "Wyczyść wszystkie",
                        "collapse": {
                            "_": "Aktywne grupowania (%d)",
                            "0": "Grupowanie"
                        },
                        "count": "{total}",
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Brak paneli wyszukań",
                        "loadMessage": "Ładuję panele wyszukań",
                        "title": "Aktywne filtry",
                        "showMessage": "Pokaż wszystko",
                        "collapseMessage": "Rozwiń wszystko"
                    },
                    "select": {
                        "cells": {
                            "_": "zaznaczono %d komórek",
                            "1": "zaznaczono %d komórkę"
                        },
                        "columns": {
                            "_": "zaznaczono %d kolumn",
                            "1": "zaznaczono %d kolumnę"
                        }
                    },
                    "stateRestore": {
                        "creationModal": {
                            "button": "Utwórz",
                            "columns": {
                                "search": "Wyszukiwanie kolumny",
                                "visible": "Widoczność kolumny"
                            },
                            "name": "Nazwa:",
                            "order": "Sortowanie",
                            "paging": "Stronicowanie",
                            "scroller": "Przewijanie",
                            "search": "Szukanie",
                            "searchBuilder": "Tworzenie zapytań",
                            "select": "Wybieranie",
                            "title": "Utwórz nowy stan",
                            "toggleLabel": "Zawiera:"
                        },
                        "duplicateError": "Stan o tej nazwie już istnieje.",
                        "emptyError": "Nazwa nie może być pusta.",
                        "emptyStates": "Brak zapisanych stanów",
                        "removeConfirm": "Czy na pewno chcesz usunąć %s?",
                        "removeError": "Nie udało się usunąć stanu.",
                        "removeJoiner": "oraz",
                        "removeSubmit": "Usuń",
                        "removeTitle": "Usuń stan",
                        "renameButton": "Zmień nazwę",
                        "renameLabel": "Nowa nazwa dla %s:",
                        "renameTitle": "Zmień nazwę stanu"
                    },
                    "decimal": ",",
                    "infoThousands": " ",
                    "thousands": " "
                },
                layout: {
                    topStart: {
                        buttons: [
                            'pageLength',
                            {
                                extend: 'excelHtml5',
                                exportOptions: {
                                     columns: [0, 1, 2, 5, 6, 7, 8]
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: [0, 1, 2, 5, 6, 7, 8]
                                }
                            },
                            'colvis']
                    }
                },
                lengthMenu: [
                    [10, 25, 50, -1],
                    ["10", "25", "50", "Wszystkie"]
                ],
                pageLength: 25,
                order: [[0, 'desc']],
                processing: true,
                serverSide: true,
                // pageLength: 20,
                ajax: {
                    url: "{{ route('filter') }}",

                    data: function (data) {
                        //console.log(data);
                        if (checkBoxDate.checked === true) {
                            data.from_date = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                            data.to_date = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                        }
                        if (checkBoxStatus.checked === true) {
                            data.status = statusArray();
                            // if (checkBoxNowe.checked === true) data.status = statusArray();
                            // if (checkBoxWrealizacji.checked === true) data.wrealizacji = 'w realizacji';
                            // if (checkBoxZrealizowane.checked === true) data.zrealizowane = 'zrealizowane';
                        }
                    }
                },
                columnDefs: [
                    {
                        targets: 8,
                        render: DataTable.render.datetime('DD.MM.YYYY')
                    },
                    {
                        // The `data` parameter refers to the data for the cell (defined by the
                        // `data` option, which defaults to the column being worked with, in
                        // this case `data: 0`.
                        render: (data, type, row) => row.street + ', ' + data + ', ' + row.post,
                        targets: 2,
                    },
                    {
                        "visible": false,
                        "targets": [3, 4]
                    }
                ],

                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'city', name: 'city'},
                    {data: 'street', name: 'street'},
                    {data: 'post', name: 'post'},
                    {data: 'email', name: 'email'},
                    {data: 'status', name: 'status'},
                    {data: 'suma', name: 'suma'},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: "id",
                        render: function (data, type, row, meta) {
                            if (type === "display") {
                                data = '<a href="zamówienie-szczegóły/' + data + '"><i class="fas fa-arrow-right-long"></i></a>';
                            }
                            return data;
                        }, orderable: false, searchable: false
                    },
                ]
            });

            $(".filter").click(function () {
                table.draw();
            });

            $(".filtrStatus").click(function () {
                //uncheckAll();
                let checkBox = document.getElementById("filtrStatus");
                if (checkBox.checked === true) {
                    enabledAll();
                } else {
                    uncheckAll();
                }
            });

            // Create uncheckall function
            function uncheckAll() {
                let inputs = document.querySelectorAll('.filtrItem');
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].checked = false;
                    inputs[i].disabled = true;

                }
            }

            function statusArray() {
                let inputs = document.querySelectorAll('.filtrItem');
                let statusArr = [];
                for (let i = 0; i < inputs.length; i++) {
                    if (inputs[i].checked) statusArr.push(inputs[i].value);
                }
                if (statusArr.length > 0) return statusArr;
            }

            // Create enabled all function
            function enabledAll() {
                let inputs = document.querySelectorAll('.filtrItem');
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].disabled = false;
                }
            }

            $(".filterOff").click(function () {
                document.querySelector('.checkFilter').checked = false;
                document.getElementById("filtrStatus").checked = false;
                uncheckAll();
                // for (let i = 0; i < inputs.length; i++) {
                //     inputs[i].checked = false;
                // }
                table.draw();
            });
        });

    </script>

@endsection
