import { BadgeQuestionMark, BellDot, MessageSquareText } from "lucide-react"
import profileImg from '../../assets/profileImg.jpg'

export default function TopBar(){
    return (
        <div className="w-full p-3 flex items-center justify-end">
            <div className="flex items-center justify-center gap-3">
                <BadgeQuestionMark size={20} className="text-gray-500"/>
                <MessageSquareText size={20} className="text-gray-500"/>
                <BellDot size={20} className="text-gray-500"/>

                <img src={profileImg} alt="" className="w-10 h-10 rounded-full object-cover border border-gray-300/40   " />
            </div>
        </div>
    )
} 