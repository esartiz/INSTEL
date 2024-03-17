function makeTimer(tt) {
    var endTime = new Date(tt);
    endTime = Date.parse(endTime) / 1000;

    var now = new Date();
    now = Date.parse(now) / 1000;

    var timeLeft = endTime - now;

    var days = Math.floor(timeLeft / 86400);
    var hours = Math.floor((timeLeft - days * 86400) / 3600);
    var minutes = Math.floor((timeLeft - days * 86400 - hours * 3600) / 60);
    var seconds = Math.floor(
        timeLeft - days * 86400 - hours * 3600 - minutes * 60
    );

    if (hours < "10") {
        hours = "0" + hours;
    }
    if (minutes < "10") {
        minutes = "0" + minutes;
    }
    if (seconds < "10") {
        seconds = "0" + seconds;
    }

    if (timeLeft < 0) {
        return 0;
    } else {
        return (
            days +
            " días, " +
            hours +
            " horas, " +
            minutes +
            " minutos y " +
            seconds +
            " segundos"
        );
    }
}

function addWeeks(date, dias) {
    date.setDate(date.getDate() + dias);
    return date;
}

function creaSemanas(grupo) {
    var options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    var fecha = new Date($("#fechaIniMod_" + grupo).val());
    //
    var texto = "";
    $(".seleccionarVigencia").html(
        '<option>-- Cambiar --</option><option value="0">Todo el Módulo</option>'
    );

    for (let i = 0; i < $("#numSemMod_" + grupo).val(); i++) {
        $(".seleccionarVigencia").append(
            '<option value="' + (i + 1) + '">Semana ' + (i + 1) + "</option>"
        );
        texto += '<tr class=""><td scope="row">' + (i + 1) + "</td>";
        var fIni = i > 0 ? addWeeks(fecha, 7) : addWeeks(fecha, 1);
        var fFin = addWeeks(new Date(fIni), 6);
        //Presc. 6 dias | Vrt 3 dias
        var auDt = (grupo.includes("S") ? addWeeks(new Date(fIni), 5) : addWeeks(new Date(fIni), 3));
        //Semana Santa
        const fstart = new Date("2024-03-24");
        const fend = new Date("2024-03-30");
        //
        if (fIni > fstart && fIni < fend) {
            var fIni = addWeeks(fecha, 7);
            var fFin = addWeeks(new Date(fIni), 6);
            var auDt = addWeeks(new Date(fIni), 3);
        }
        texto +=
            "<td>" +
                fIni.toLocaleDateString("es-ES", options) +
                "<br>" +
                fFin.toLocaleDateString("es-ES", options) +
                "<br><b>Aut: " +
                auDt.toLocaleDateString("es-ES", options) +
                "</b></td>";
        texto += "</tr>";
    }
    $("#resultTime_" + grupo).html(texto);
}

$(".cerrarModal").click(function () {
    $(".modal").modal("hide");
});

$(document).ready(function () {
    $("#usuariosTable").DataTable();
    $(".btwToolt").tooltip();

    $(".forGrupo").each(function (index) {
        const grp = ($(this).attr("dt-f")).split('');
        const grpID = ["", "A Virtual", "B Virtual", "C Virtual", "D Virtual", "A Sabatino", "B Sabatino", "C Sabatino", "D Sabatino"];
        $(this).text(grp[0] + grp[1] + grp[2] + grp[3] + '-' + grpID[grp[4]]);
    });

    $(".forFecha").each(function (index) {
        const date = new Date(($(this).attr("dt-f")).replace(/-/g, '\/'));
        const days = [
            "Dom",
            "Lun",
            "Mar",
            "Mié",
            "Jue",
            "Vie",
            "Sáb",
        ];
        const daysLong = [
            "Domingo",
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
        ];
        const months = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ];
        const theYear = date.getFullYear();
        const theMonth = date.getMonth();
        const theDate = date.getDate();
        const theDay = date.getDay();
        const theHH = date.getHours();
        const theMM = date.getMinutes();
        var laHH, losMM;
        (theHH < 9 ? laHH = "0" + theHH : laHH = theHH);
        (theMM < 9 ? losMM = "0" + theMM : losMM = theMM);


        if ($(this).attr("dt-fmt") == "0") {
            var dataFinal = `${daysLong[theDay]}, ${months[theMonth]} ${theDate} de ${theYear}`
        } else if ($(this).attr("dt-fmt") == "10") { 
            var dataFinal = `${daysLong[theDay]} ${theDate}`
        } else {
            var dataFinal = `${days[theDay]}, ${months[theMonth]} ${theDate} de ${theYear} a las ${laHH}:${losMM}`
        }
        $(this).text(dataFinal);
    });
});


$('.cargaDocFl').change(function () {
    this.form.submit();
});


//-------> us.create

$('#imprimirContrato').click(function () {
    window.frames["printf"].focus();
    window.frames["printf"].print();
});

function verContratoSE(dd, tipo) {
    if (tipo == "contrato") {
        window.location = '/' + tipo + '/' + dd + '/' + $('#contratoGr').val();
    } else {
        $('#printRec').attr('src', '/' + tipo + '/' + dd);
        $('#verPagareM').modal('show');
    }
}

/*
$('#verPagareM').on('show.bs.modal', function(event) {
    var button = event.relatedTarget
    var recipient = button.getAttribute('data-pg')
    if(button.getAttribute('data-type') == "contrato"){
        console.log(recipient + '/' + $('#contratoGr').val());
        $('#printRec').attr('src', recipient + '/' + $('#contratoGr').val());
    } else {
        $('#printRec').attr('src', recipient);
    }
})
*/

$(document).ready(function () {
    $("#rol").val("{{ $user->rol }}");
    $("#listaModulos").DataTable();
    if ($('option:selected', '#prgID').attr('myInfo')) {
        buscaSemestre($('option:selected', '#prgID').attr('myInfo'));
    }
    generarCodigo("inicio");
});
$('#docInd').change(function () {
    $('#password_c').val($(this).val());
});

$('#prgID').change(function () {
    var option = $('option:selected', this).attr('myInfo');
    buscaSemestre(option);
})

function buscaSemestre(data) {
    var ctSem = data.split("|");
    $('#cicloID').html('<option value="">Seleccione</option>');
    for (let i = 1; i < ctSem.length; i++) {
        $('#cicloID').append('<option value="' + i + '"' + (i == $('#guiaCiclo').val() ? ' selected' : '') + '>' + ctSem[i] + '</option>');
    }
}

var modSelects = [];

function generarCodigo(tt) {
    let codigoDat = $('#cod1').val() + $('#cod2').val();
    if (tt == undefined) {
        $.getJSON("/buscacode/" + codigoDat, function (data) {
            if (data == 1) {
                alert("Existe un estudiante con el código asignado, cámbielo antes de guardar")
            }
        })
    }
    $('#elCodigo').val(codigoDat);
}

$('.selectMateria').click(function () {
    var checkDt = $('#ff_' + $(this).attr('data'));
    var dato = $(this).attr('data');

    if (checkDt.prop('checked') == true) {
        checkDt.prop('checked', false);
        var index = modSelects.indexOf(dato);
        if (index !== -1) {
            modSelects.splice(index, 1);
        }
    } else {
        modSelects.push(dato)
        checkDt.prop('checked', true);
    }
    $('#matriculaMasiva').val(modSelects);
})

var loadFile = function (event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    if (output.width < output.height) {
        $('#fileHelpId').text("Recuerde que la foto debe ser vertical")
    }
    output.onload = function () {
        URL.revokeObjectURL(output.src)
    }
};

function sendFileMatri(nn) {
    $(".fileForm" + nn).submit();
}

$('#tipoDoc').change(function () {
    var getDT = $(this).val();
    if (getDT == "TI") {
        $('#extraDoc').show();
    } else {
        $('#extraDoc').hide();
    }
})
if ($('#tipoDoc').val() == "TI") {
    $('#extraDoc').show();
} else {
    $('#extraDoc').hide();
}

function formatURLDrive() {
    var frmt = ($('#g_ruta').val()).split('/');
    $('#g_ruta').val(frmt[5])
}

function colorPromNt(nProm) {
    return (nProm < 3.5 ? 'nPerdida' : (nProm > 4.5 ? 'nAprobada' : 'nExcelente'));
}



//-----> RADIO INSTEL

var source = "https://cloud8.vsgtech.co/8064/;";
var audio = new Audio();
audio.addEventListener("load", function () {
    audio.play();
}, true);
audio.src = source;
if (localStorage.getItem('soundplay') == 'on') {
    audio.autoplay = true;
}
audio.addEventListener("play", function () {
    checkSound()
}, false);
$(".audio-player").click(function (e) {
    var sn = (audio.paused) ? audio.play() : audio.pause();
    checkSound()
});
function checkSound() {
    if (audio.paused) {
        localStorage.setItem('soundplay', 'off');
        $('.audioPlay').show();
        $('.audioStop').hide();
    } else {
        localStorage.setItem('soundplay', 'on');
        $('.audioPlay').hide();
        $('.audioStop').show();
    }
}
checkSound()


var ipu = localStorage.getItem('ifPopUp');
if (!ipu) {
    setTimeout(function () {
        $('#admodal').find('.item').first().addClass('active');
        $('#admodal').modal({
            backdrop: 'static',
            keyboard: false
        });
    }, 2000);
    localStorage.setItem('ifPopUp', '1');
} 