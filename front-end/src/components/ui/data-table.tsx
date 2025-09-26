
import { useState, useEffect } from 'react';
import { DataTable } from 'primereact/datatable';
import { Column } from 'primereact/column';
import { InputSwitch, type InputSwitchChangeEvent } from 'primereact/inputswitch';
import axios from "axios";
// import { ProductService } from './service/ProductService';

interface User {
    id?: string;
    firstName?: string;
    lastName?: string;
    email?: string;
    phone?: string;
    formations?: string;
    role?: string;
}

interface Props {
    view : "admins" | "formateurs";
}

export default function DataView({view}:Props) {
    const [users , setUsers] = useState<User[]>([]);
    const [selectedUsers, setSelectedUsers] = useState<User | null>(null);
    const [rowClick, setRowClick] = useState<boolean>(true);
   

    useEffect(() => {
        const url =
            view === "admins"
            ? "http://localhost:8000/api/admins"
            : "http://localhost:8000/api/formateurs";

        axios.get(url)
            .then((res) => setUsers(res.data.data))
            .catch((err) => console.log(err));
    },[view]);
    
    return (
        <div className="card bg-white border border-gray-400/40 shadow-md rounded-xl p-6">
        <div className="flex justify-between items-center mb-4">
            <h2 className="text-xl font-semibold text-gray-700">
                {view === "admins" ? "Liste des Admins" : "Liste des Formateurs"}
            </h2>
            <div className="flex items-center gap-2">
                <label htmlFor="input-rowclick" className="text-sm text-gray-600">Row Click</label>
                <InputSwitch 
                    inputId="input-rowclick" 
                    checked={rowClick} 
                    onChange={(e: InputSwitchChangeEvent) => setRowClick(e.value!)} 
                />
            </div>
        </div>

        <DataTable
            value={users}
            selectionMode={rowClick ? undefined : 'multiple'}
            selection={selectedUsers}
            onSelectionChange={(e: { value: typeof selectedUsers }) => setSelectedUsers(e.value)}
            dataKey="id"
            paginator
            rows={5}
            rowsPerPageOptions={[5, 10, 20]}
            stripedRows
            showGridlines
            size="small"
            className="rounded-lg overflow-hidden text-sm"
            rowClassName={() => ({
                "hover:bg-[#efefef] transition-colors duration-200 rounded-md ": true, // smooth hover effect
            })}
        >
            <Column selectionMode="multiple" headerStyle={{ width: "3rem" }} />

            <Column
                field="firstName"
                header="First Name"
                sortable
                className=" py-4"
            />
            <Column
                field="lastName"
                header="Last Name"
                sortable
                className=" py-4"
            />
            <Column
                field="email"
                header="Email"
                sortable
                className=" py-4"
            />
            <Column
                field="phone"
                header="Phone"
                sortable
                className=" py-4"
            />

            {view === "formateurs" ? (
                <Column field="formations" header="Formations" className=" py-4" />
            ) : (
                <Column field="role" header="Role" className=" py-4" />
            )}
        </DataTable>

    </div>
    );
}
        