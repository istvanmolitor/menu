// @ts-ignore
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import axios from 'axios';
import { useState, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function AdminSidebarMenu(): any {

    const [menuItems, setMenuItems] = useState([]);
    const page = usePage();

    useEffect(() => {
        axios.get('/api/menu/admin')
            .then(response => setMenuItems(response.data))
            .catch(error => console.error('Menu fetch error:', error));
    }, []);

    return (
        <SidebarGroup className="px-2 py-0">
            <SidebarGroupLabel>Platform</SidebarGroupLabel>
            <SidebarMenu>
                {menuItems.map((item) => (
                    <SidebarMenuItem key={item.title}>
                        <SidebarMenuButton
                            asChild isActive={item.href === page.url}
                            tooltip={{ children: item.title }}
                        >
                            <Link href={item.href} prefetch>
                                {item.icon && <Icon iconNode={item.icon} className="h-5 w-5" />}
                                <span>{item.title}</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                ))}
            </SidebarMenu>
        </SidebarGroup>
    );
}
