export default function(value) {
    if (!value) return
    return new Intl.NumberFormat('pt-BR', { style: 'percent' }).format(Number(value) / 100);
}