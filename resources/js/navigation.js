import {
    LayoutDashboard, FileText, Users, UserCircle, KeyRound, ListTree,
} from 'lucide-vue-next';

export const mainNav = [
    { text: 'Dashboard', route: 'home', icon: LayoutDashboard },
    { text: 'Ocorrências', route: 'index-occurrence', icon: FileText },
];

export const lookupNav = {
    text: 'Pré-definidos',
    icon: ListTree,
    items: [
        { text: 'Naturezas de ocorrência', route: 'index-nature' },
        { text: 'Tipos de ocorrência', route: 'index-type' },
        { text: 'Sistemas de proteção', route: 'index-fireprotection' },
        { text: 'Tipos de socorristas', route: 'index-rescuer' },
        { text: 'Tipos de problemas', route: 'index-problem' },
        { text: 'Características do local', route: 'index-placefreature' },
        { text: 'Meios de chamado', route: 'index-meanused' },
        { text: 'Utilização do local', route: 'index-placeuse' },
    ],
};

export const adminNav = [
    { text: 'Usuários', route: 'index-user', icon: Users },
];

export const profileNav = [
    { text: 'Perfil', route: 'profile', icon: UserCircle },
    { text: 'Alterar senha', route: 'password', icon: KeyRound },
];
