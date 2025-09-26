import { useState } from "react";
import DataTable from "./ui/data-table"
import SwitchButtons from "./ui/switch-buttons"
import TopBar from "./ui/top-bar"

export default function Page(){
    const [view, setView] = useState<"admins" | "formateurs">("admins");
    return (
        <div className="col-span-10 flex flex-col gap-10 ">

            <TopBar/>
            <SwitchButtons setView={setView} view={view}/>
            <DataTable view={view}/>
        </div>
    )
}


