import { Building2, PlusIcon, User2 } from "lucide-react";

interface Props{
    setView : (view: "admins" | "formateurs")=>void;
    view: "admins" | "formateurs";
}

export default function SwitchButtons({setView,view}:Props){

    const baseClasses ="flex items-center gap-10 py-2 px-3 w-fit rounded-full border cursor-pointer transition";
    const activeClasses = "text-blue-700  border-blue-600";
    const inactiveClasses = "text-blue-500 border-blue-500/50 hover:bg-blue-400/40";

    return (

        <div className=" w-full flex flex-col gap-8 ">
            <div className="w-full flex items-center justify-end" >
                <div className="flex items-center gap-3 p-2 text-blue-700 w-fit rounded-md border-2 border-blue-500 hover:bg-blue-400/40">
                    <PlusIcon size={20} className="text-blue-500"/>
                    <span className=""> 
                        Ajouter 
                        <span className="font-semibold">
                           {view == 'formateurs' ? " Formateur" : " Admin"} 
                        </span> 
                    </span>
                </div>
            </div>

            <div className="w-full flex items-center gap-2 justify-center">
                <div onClick={() => setView("formateurs")} className={`${baseClasses} ${
                    view === "formateurs" ? activeClasses : inactiveClasses }`}>
                    <span className=""> Formateur</span> 
                    <div className="p-1 rounded-full border border-blue-500 relative">
                        <User2 size={20} className="text-blue-500"/>
                        <div className="bg-blue-500 text-white font-bold text-xs rounded-full  px-2 absolute right-6 bottom-1">
                            <span>120</span>
                        </div>
                    </div>
                </div>

                <div onClick={() => setView("admins")} className={`${baseClasses} ${
            view === "admins" ? activeClasses : inactiveClasses}`}>
                    <span className="">Admin</span> 
                    <div className="p-1 rounded-full border border-blue-500 relative">
                        <Building2 size={20} className="text-blue-500"/>
                        <div className="bg-blue-500 text-white font-bold text-xs rounded-full  px-2 absolute right-6 bottom-1">
                            <span>33</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )

}
