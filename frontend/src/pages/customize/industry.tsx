import { useRouter } from 'next/router'
import React, { useState } from 'react'
import { IconType } from 'react-icons'
import {
  FaFish,
  FaWarehouse,
  FaStore,
  FaMoneyBillAlt,
  FaHandshake,
  FaBriefcaseMedical,
  FaUsers,
} from 'react-icons/fa'
import { GiStonePile, GiElectric } from 'react-icons/gi'
import { HiAcademicCap } from 'react-icons/hi2'
import { IoIosConstruct } from 'react-icons/io'
import {
  MdOutlinePrecisionManufacturing,
  MdLaptopChromebook,
  MdRealEstateAgent,
  MdAccountBalance,
} from 'react-icons/md'

interface IndustryButtonProps {
  Icon: IconType
  label: string
  isSelected: boolean
  onClick: () => void
}

const IndustryButton: React.FC<IndustryButtonProps> = ({
  Icon,
  label,
  isSelected,
  onClick,
}) => {
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
  )
}

interface Industry {
  Icon: IconType
  label: string
  id: number
}

const industries: Industry[] = [
  { Icon: FaFish, label: '水産・農林', id: 1 },
  { Icon: GiStonePile, label: '鉱業', id: 2 },
  { Icon: IoIosConstruct, label: '建設業', id: 3 },
  { Icon: MdOutlinePrecisionManufacturing, label: '製造業', id: 4 },
  { Icon: GiElectric, label: '電気、ガス業', id: 5 },
  { Icon: FaWarehouse, label: '倉庫・運輸関連業', id: 6 },
  { Icon: MdLaptopChromebook, label: '情報通信', id: 7 },
  { Icon: FaStore, label: '商業', id: 8 },
  { Icon: FaMoneyBillAlt, label: '金融、保険', id: 9 },
  { Icon: MdRealEstateAgent, label: '不動産', id: 10 },
  { Icon: FaHandshake, label: 'サービス業', id: 11 },
  { Icon: MdAccountBalance, label: '官公庁、地方自治体', id: 12 },
  { Icon: FaStore, label: '飲食店・宿泊業', id: 13 },
  { Icon: FaBriefcaseMedical, label: '医療・福祉', id: 14 },
  { Icon: HiAcademicCap, label: '教育・学習支援業', id: 15 },
  { Icon: FaUsers, label: '財団法人・社団法人・宗教法人', id: 16 },
]

export default function HomePage() {
  const [selectedIndustries, setSelectedIndustries] = useState<number[]>([])
  const router = useRouter()

  const toggleIndustry = (id: number) => {
    setSelectedIndustries((prev) =>
      prev.includes(id) ? prev.filter((i) => i !== id) : [...prev, id],
    )
  }

  const handleNext = () => {
    const queryString = selectedIndustries
      .map((id) => `industry-id=${id}`)
      .join('&')
    router.push(`/customize/company/?${queryString}`)
  }

  return (
    <div className="container mx-auto px-4 py-8 bg-gray-100 min-h-screen">
      <h1 className="text-3xl font-bold mb-6 text-center text-purple-800">
        興味のある業種を選んでください
      </h1>
      <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8">
        {industries.map((industry) => (
          <IndustryButton
            key={industry.id}
            Icon={industry.Icon}
            label={industry.label}
            isSelected={selectedIndustries.includes(industry.id)}
            onClick={() => toggleIndustry(industry.id)}
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
  )
}
