function imprime(guia, result){
    qz.printers.find("Termica").then(function(found) {
    // qz.printers.find("PDF").then(function(found) {
        var config = qz.configs.create(found, {copies: 1, units: "in", density: "600"});               // Exact printer name from OS
        var hoje = moment().format(': DD/MM/YYYY - HH:mm:ss');
        var iniciaCupom = [
            ep_init,
            ep_center_align,
            { 
                type: 'raw', 
                format: 'image', 
                flavor: 'file', 
                data: '/images/logo_impressao.png', 
                options: {
                     language: "escp", 
                     dotDensity: 'double' 
                    }, 
            },
            ep_bold_on,
            ep_font_double,
            'Autorizacao: ' + guia['id'] + ep_line_break,
            ep_font_standard,
            ep_line_break,
            ep_bold_on,
            'Data Emissao: ' + ep_bold_off + hoje + ep_line_break,
            ep_left_align,
            ep_bold_on,
            'Usuario:' + ep_bold_off + ' ' + guia['usuario'] + ' - ' + guia['nome_usuario'] + ep_line_break + ep_line_break,
            ep_bold_on,
            'Nim: ' + guia['nim'] + ' ' + ep_bold_off + ep_line_break + ep_line_break,
            ep_bold_on,
            'Nome: ' + ep_bold_off + ': ' + guia['paciente'] + ep_line_break + ep_line_break,
            ep_bold_on,
            'Procedimentos: ',
            ep_line_break,
        ];

        var procedimentos = [], 
            preparos = [
                ep_line_break,
                ep_bold_on,
                'Preparos: ',
                ep_bold_off,
                ep_line_break,
                ep_line_break,
            ],
            agendamentos = [
                ep_line_break,
                ep_line_break,
                ep_bold_on,
                'Agendamentos: ',
                ep_bold_off,
                ep_line_break,
                ep_line_break,
            ];;

        result.forEach(element => {
            procedimentos.push(' ');
            procedimentos.push(element['quantidade']);
            procedimentos.push('x ');
            procedimentos.push(element['procedimento']);
            procedimentos.push(ep_line_break);
            procedimentos.push('    ');
            procedimentos.push(element['quantidade']);
            procedimentos.push('x ');
            procedimentos.push(element['valor']);
            procedimentos.push(' = ');
            procedimentos.push(element['valor_total']);
            procedimentos.push(ep_line_break);

            if(!jQuery.isEmptyObject(element['preparo'])){
                preparos.push(element['preparo']);
                preparos.push(ep_line_break);
            }
        });

        var local = [
            ep_line_break,
            ep_line_break,
            'Local:' + ep_bold_off,
            ep_line_break,
            ep_line_break,
            'Clinica IntegrallMed, Rua Esmeralda Graciliano dos Santos, 50, Salas 2 a 8, Centro, Ubatuba - SP', 
        ]

        // Adiciona agendamentos
        getAgendamentos(guia['id'], function (result) {
            result.forEach(element => {
                var dataAgendamento = moment(element['start']).format('DD/MM/YYYY - HH:mm:ss');

                console.log(dataAgendamento);
                agendamentos.push(moment(element['start']).format('DD/MM/YYYY - HH:mm:ss'));
                agendamentos.push(ep_line_break);
            });

            var finalizaCupom = [
                ep_line_break,
                ep_line_break,
                ep_line_break,
                ep_bold_on,
                'Conveniado: ' + ep_bold_off + '\n' + guia['profissional'] + ep_line_break + ep_line_break,
                ep_line_break,
                ep_line_break,
                ep_center_align,
                ep_bold_on,
                '______________________________',
                ep_line_break,
                'Assinatura',
                ep_bold_off,
                ep_line_break,
                ep_line_break,
                ep_line_break,
                ep_left_align,
                'Realizar somente os procedimentos que constam nessa guia\n',
                ep_line_break,
                ep_line_break,
                ep_line_break,
                ep_line_break,
                ep_line_break,
                ep_line_break,
                ep_cut_paper, 
            ];

            var impressao = $.merge(iniciaCupom, procedimentos);
            impressao = $.merge(impressao, local);
            impressao = $.merge(impressao, agendamentos);
            impressao = $.merge(impressao, preparos);
            impressao = $.merge(impressao, finalizaCupom);

            qz.print(config, impressao).then(function() {
                // alert("Sent data to printer");
            });
        });

        
     });
}

function imprimeGuia(guia){
    getProcedimentosGuia(guia['id'], function (result) {
        console.log(guia);

        if(qz.websocket.isActive())
            imprime(guia, result);
        else{
            qz.websocket.connect().then(function() {
                imprime(guia, result);
             });
        }
    });
}

$(document).ready(function(){

    // $('#tabela-guias tbody').on('click', 'button.btn-imprimir', function () {
    //     var guia = tabela_guias.row($(this).parents('tr')).data();

    //     if (typeof guia == "undefined") {
    //         guia = tabela_guias.row(this).data();
    //     }

    //     imprimeGuia(guia);
    // });
    
});