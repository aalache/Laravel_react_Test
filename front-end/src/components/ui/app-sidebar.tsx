import {ShieldUser , LayoutDashboard, Users, SlidersVertical, Landmark, Building2, GraduationCap, University, PanelLeft } from "lucide-react"
import logo from "../../assets/logo.png"


export default function AppSidebar() {
  return (
    <div className="border col-span-3 border-gray-300 rounded-2xl p-4 flex flex-col h-full min-h-screen space-y-8  text-sm">
       <a className="flex items-center justify-between">
            <img src={logo} alt="logo" className=" object-fill  w-36" />
            <PanelLeft size={25} className="text-gray-400 "/>
       </a>

       <div className=" flex flex-col items-start space-y-3">
            <a className="flex items-center justify-start gap-5 p-3 rounded-md  hover:bg-blue-400/40 w-full text-md text-gray-500 ">
                <LayoutDashboard size={20} className="text-gray-500"/>
                <span>Gestion Commercial</span>
            </a>

            <a className="flex items-center justify-start gap-5 p-3 rounded-md  hover:bg-blue-400/40 w-full text-md text-gray-500">
                <ShieldUser size={20} className="text-gray-500"/>
                <span>Gestion Administrative</span>
            </a>
        

            <a className="flex items-center justify-start gap-5 p-3 rounded-md  hover:bg-blue-400/40 w-full text-md text-gray-500">
                <LayoutDashboard size={20} className="text-gray-500"/>
                <span>Gestion Des Formations</span>
            </a>
        

            <div className=" space-y-2  w-full">
                <div className=" flex  gap-5 items-center justify-start p-3 rounded-md  text-md text-gray-500 hover:bg-blue-400/40 w-full">
                    <Users size={20} className="text-gray-500   "/>
                    <span>Parties Prenantes</span>
                </div>

                <div className="flex flex-col border-l border-gray-300 ml-4 ">
                    <div className="flex items-center justify-start gap-5 p-3 rounded-md  hover:bg-blue-400/40 w-full text-md text-gray-500">
                        <University size={20} className="text-gray-500"/>
                        <span>Formateurs</span>
                    </div>
                    <div className="flex items-center justify-start gap-5 p-3 rounded-md  hover:bg-blue-400/40 w-full text-md text-gray-500">
                        <GraduationCap size={20} className="text-gray-500"/>
                        <span>Apprenants</span>
                    </div>
                    <div className="flex items-center justify-start gap-5 p-3 rounded-md  hover:bg-blue-400/40 w-full text-md text-gray-500">
                        <Building2 size={20} className="text-gray-500"/>
                        <span>Entreprise</span>
                    </div>
                    <div className="flex items-center justify-start gap-5 p-3 rounded-md  hover:bg-blue-400/40 w-full text-md text-gray-500">
                        <Landmark size={20} className="text-gray-500"/>
                        <span>Financeurs</span>
                    </div>
                </div>
            </div>
        
            <div className="flex items-center justify-start gap-5 p-3 rounded-md  hover:bg-blue-400/40 w-full text-md text-gray-500">
                <SlidersVertical size={20} className="text-gray-500"/>
                <span>Marque Blanche</span>
            </div>
        </div>
       
    </div>
  )
}