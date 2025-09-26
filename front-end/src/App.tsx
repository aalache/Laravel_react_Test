
import './App.css'
import Page from './components/page'
import AppSidebar  from './components/ui/app-sidebar'

function App() {

  return (
    <div className=' grid grid-cols-13 gap-3 p-5 bg-white w-full'>
     
        <AppSidebar  />  
        <Page/>
    </div>
  )
}
export default App
