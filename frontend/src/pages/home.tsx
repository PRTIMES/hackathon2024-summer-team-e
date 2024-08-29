import React, { useState } from 'react';
import { FaFish, FaWarehouse, FaStore, FaMoneyBillAlt, FaHandshake, FaBriefcaseMedical, FaUsers } from "react-icons/fa";
import { GiStonePile, GiElectric } from "react-icons/gi";
import { IoIosConstruct } from "react-icons/io";
import { MdOutlinePrecisionManufacturing, MdLaptopChromebook, MdRealEstateAgent, MdAccountBalance } from "react-icons/md";
import { HiAcademicCap } from "react-icons/hi2";

const IndustryButton = ({ Icon, label, isSelected, onClick }) => {
  return (
    <button 
      onClick={onClick}
      className={`flex flex-col items-center justify-center p-4 rounded-lg transition-all duration-200 ${
        isSelected 
          ? 'bg-purple-600 text-white shadow-lg transform scale-105' 
          : 'bg-purple-100 text-gray-800 hover:bg-purple-200'
      }`}
    >
      <Icon className="text-2xl mb-2" />
      <span className="text-sm text-center">{label}</span>
    </button>
  );
};

const industries = [
  { Icon: FaFish, label: "水産・農林" },
  { Icon: HiAcademicCap, label: "教育" },
  { Icon: GiStonePile, label: "鉱業" },
  { Icon: IoIosConstruct, label: "建設業" },
  { Icon: MdOutlinePrecisionManufacturing, label: "製造業" },
  { Icon: GiElectric, label: "電気、ガス業" },
  { Icon: FaWarehouse, label: "倉庫・運輸関連業" },
  { Icon: MdLaptopChromebook, label: "情報通信" },
  { Icon: FaStore, label: "商業" },
  { Icon: FaMoneyBillAlt, label: "金融、保険" },
  { Icon: MdRealEstateAgent, label: "不動産" },
  { Icon: FaHandshake, label: "サービス業" },
  { Icon: MdAccountBalance, label: "官公庁、地方自治体" },
  { Icon: FaBriefcaseMedical, label: "医療・福祉" },
  { Icon: FaUsers, label: "財団法人・社団法人・宗教法人" },
];

export default function HomePage() {
  const [selectedIndustries, setSelectedIndustries] = useState([]);

  const toggleIndustry = (index) => {
    setSelectedIndustries(prev => 
      prev.includes(index)
        ? prev.filter(i => i !== index)
        : [...prev, index]
    );
  };

  const handleNext = () => {
    console.log("Selected industries:", selectedIndustries.map(i => industries[i].label));
    // Here you would typically navigate to the next page or fetch data based on selections
  };

  return (
    <div className="container mx-auto px-4 py-8 bg-gray-100 min-h-screen">
      <h1 className="text-3xl font-bold mb-6 text-center text-purple-800">興味のある業種を選んでください</h1>
      <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8">
        {industries.map((industry, index) => (
          <IndustryButton
            key={index}
            Icon={industry.Icon}
            label={industry.label}
            isSelected={selectedIndustries.includes(index)}
            onClick={() => toggleIndustry(index)}
          />
        ))}
      </div>
      <div className="flex justify-center">
        <button 
          onClick={handleNext}
          className="bg-purple-600 text-white px-6 py-2 rounded-full font-semibold hover:bg-purple-700 transition-colors duration-200"
          disabled={selectedIndustries.length === 0}
        >
          次へ
        </button>
      </div>
    </div>
  );
}