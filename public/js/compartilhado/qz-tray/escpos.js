// COMANDOS
const ep_init = '\x1B' + '\x40';
// const ep_line_break = '\x0A';
const ep_line_break = '\n';
const ep_cut_paper = '\x1B' + '\x69';
const ep_open_drawer = '\x10' + '\x14' + '\x01' + '\x00' + '\x05';

// ALINHAMENTO TEXTO
const ep_center_align = '\x1B' + '\x61' + '\x31';
const ep_left_align = '\x1B' + '\x61' + '\x30';
const ep_right_align = '\x1B' + '\x61' + '\x32';

// NEGRITO
const ep_bold_on = '\x1B' + '\x45' + '\x0D';
const ep_bold_off = '\x1B' + '\x45';

// TAMANHO FONTE
const ep_font_standard = '\x1D' + '\x21' + '\x00';
const ep_font_double = '\x1D' + '\x21' + '\x11';
const ep_font_small = '\x1B' + '\x4D' + '\x31';
const ep_font_normal = '\x1B' + '\x4D' + '\x30';

// EM
const ep_em_on = '\x1B' + '\x21' + '\x30';
const ep_em_off = '\x1B' + '\x21' + '\x0A' + '\x1B' + '\x45';