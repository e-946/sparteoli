const formatter = new Intl.DateTimeFormat('pt-BR', {
    timeZone: 'America/Bahia',
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
});

export function formatDateTime(value) {
    if (! value) {
        return null;
    }

    return formatter.format(new Date(value)).replace(',', ' -');
}

const dateOnlyFormatter = new Intl.DateTimeFormat('pt-BR', {
    timeZone: 'UTC',
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
});

export function formatDate(value) {
    if (! value) {
        return null;
    }

    return dateOnlyFormatter.format(new Date(`${value}T00:00:00Z`));
}

export function formatZipCode(value) {
    if (! value) {
        return null;
    }

    return value.replace(/(\d{2})(\d{3})(\d{3})/, '$1.$2-$3');
}

export function formatPhone(value) {
    if (! value) {
        return null;
    }

    return value.replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4');
}
